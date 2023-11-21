<?php

namespace Streams\Ui\Resources;

use Streams\Ui\Navigation\NavigationItem;
use Streams\Ui\Resources\Concerns;
use Streams\Ui\Support\Concerns\HasTitle;
use Streams\Ui\Support\Concerns\HasNavigation;

abstract class Resource
{
    use HasTitle;
    use HasNavigation;

    use Concerns\HasRoutes;

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
}
