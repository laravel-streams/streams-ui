<?php

namespace Streams\Ui\Resources;

use Streams\Core\Entry\Entry;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Ui\Builders\Concerns as Common;
use Streams\Ui\Builders\Navigation\NavigationItem;
use Streams\Ui\Builders\Breadcrumbs\Breadcrumbs;

abstract class Resource
{
    use Common\HasTitle;
    use Common\ProvidesNavigationItem;
    use Concerns\HasNavigationGroups;
    use Concerns\HasRoutes;
    use Concerns\HasStream;
    use HasMemory;

    public static function getUrl(
        string $name = 'index',
        array $parameters = [],
        bool $isAbsolute = true,
        ?string $panel = null,
        // ?Model $tenant = null
    ): string {

        // $parameters['tenant'] ??= ($tenant ?? Filament::getTenant());

        $routeBaseName = static::getRouteBaseName(panel: $panel);

        return route("{$routeBaseName}.{$name}", $parameters, $isAbsolute);
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make(static::getNavigationLabel())
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(
                    fn () => request()->routeIs(static::getRouteBaseName().'.*')
                )
                ->sortOrder(static::getNavigationSort())
                ->badge(
                    static::getNavigationBadge(),
                    static::getNavigationBadgeColor()
                )
                ->url(static::getNavigationUrl()),
        ];
    }

    /**
     * Declarative tabs: page name => label.
     */
    protected static array $tabs = [];

    public static function tabs(): array
    {
        return static::$tabs;
    }

    /**
     * Tabs resolved with url and route-derived active state.
     */
    public static function getTabs(array $parameters = []): array
    {
        $base = static::getRouteBaseName();

        return collect(static::tabs())->map(fn (string $label, string $name) => [
            'name' => $name,
            'label' => $label,
            'url' => static::getUrl($name, $parameters),
            'active' => request()->routeIs("$base.$name"),
        ])->values()->all();
    }

    /**
     * Breadcrumb chain: resource index, then the current page label.
     */
    public static function getBreadcrumbs(?string $page = null, array $parameters = []): Breadcrumbs
    {
        $items = [static::getNavigationLabel() => static::getUrl('index')];

        if ($page && $page !== 'index') {
            $items[static::tabs()[$page] ?? str($page)->headline()->toString()] = static::getUrl($page, $parameters);
        }

        return Breadcrumbs::make($items);
    }

    public static function getPages(): array
    {
        return [];
    }

    public static function getActions(): array
    {
        return [];
    }

    /**
     * Eloquent model class backing this resource (null = Streams entries).
     */
    protected static ?string $model = null;

    public static function getModel(): ?string
    {
        return static::$model;
    }

    /**
     * Records query: an Eloquent Builder when a model is declared,
     * otherwise the stream's Criteria.
     */
    public static function scopedQuery(): \Streams\Core\Criteria\Criteria|\Illuminate\Database\Eloquent\Builder
    {
        if ($model = static::getModel()) {
            return $model::query();
        }

        return static::streamEntries();
    }

    public static function resolveModelRouteBinding(int|string $key): ?\Illuminate\Database\Eloquent\Model
    {
        $query = static::scopedQuery();

        return $query->where($query->getModel()->getRouteKeyName(), $key)->first();
    }

    public static function resolveRecord(int|string $key): ?object
    {
        return static::getModel()
            ? static::resolveModelRouteBinding($key)
            : static::resolveEntryRouteBinding($key);
    }

    public static function resolveEntryRouteBinding(int|string $key): ?Entry
    {
        $stream = Streams::make(static::getStream());

        return $stream
            ->repository()
            ->findBy($stream->config('key_name', 'id'), $key);
    }
}
