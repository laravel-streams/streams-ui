<?php

namespace Streams\Ui\Resources;

use Streams\Core\Entry\Entry;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Ui\Builders\Concerns as Common;
use Streams\Ui\Builders\Navigation\NavigationItem;

abstract class Resource
{
    use Common\HasTitle;
    use Concerns\HasNavigationGroups;
    use Common\ProvidesNavigationItem;

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

    public static function getPages(): array
    {
        return [];
    }

    public static function getActions(): array
    {
        return [];
    }

    public static function resolveEntryRouteBinding(int|string $key): ?Entry
    {
        $stream = Streams::make(static::getStream());

        return $stream
            ->repository()
            ->findBy($stream->config('key_name', 'id'), $key);
    }
}
