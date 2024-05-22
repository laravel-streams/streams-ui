<?php

namespace Streams\Ui\Resources;

use Streams\Core\Entry\Entry;
use Streams\Ui\Resources\Concerns;
use Streams\Ui\Navigation\NavigationItem;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Builders\Concerns\HasTitle;
use Streams\Ui\Builders\Concerns\HasNavigation;

abstract class Resource
{
    use HasTitle;
    use HasNavigation;

    use Concerns\HasRoutes;
    use Concerns\HasStream;

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
                ->url(static::getNavigationUrl())
                ->htmlAttributes([
                    'wire:navigate' => true,
                ]),
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
}
