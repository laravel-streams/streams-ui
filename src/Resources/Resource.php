<?php

namespace Streams\Ui\Resources;

use Streams\Core\Entry\Entry;
use Streams\Ui\Resources\Concerns;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Builders\Concerns\HasTitle;
use Streams\Ui\Builders\Concerns\HasNavigation;
use Streams\Ui\Builders\Navigation\NavigationItem;

abstract class Resource
{
    use HasTitle;
    use HasNavigation;

    use Concerns\HasRoutes;

    protected static ?string $stream = null;

    public static function getUrl(
        string $name = 'index',
        array $parameters = [],
        bool $isAbsolute = true,
        ?string $panel = null,
        //?Model $tenant = null
    ): string {

        //$parameters['tenant'] ??= ($tenant ?? Filament::getTenant());

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
                    fn () => request()->routeIs(static::getRouteBaseName() . '.*')
                )
                ->sort(static::getNavigationSort())
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

    public static function resolveEntryRouteBinding(int | string $key): ?Entry
    {
        $stream = Streams::make(static::getStream());

        return $stream
            ->repository()
            ->findBy($stream->config('key_name', 'id'), $key);
    }

    public static function getStream(): string
    {
        return static::$stream ?? static::getSlug();
    }
}
