<?php

namespace Streams\Ui\Resources\Concerns;

use Streams\Ui\support\Facades\UI;
use Illuminate\Support\Facades\Route;
use Streams\Ui\Builders\Panels\Panel;

trait HasRoutes
{
    protected static ?string $slug = null;

    protected static string | array $middleware = [];

    protected static string | array $withoutMiddleware = [];

    public static function routes(Panel $panel): void
    {
        $slug = static::getSlug();

        Route::name(
            (string) str($slug)
                ->replace('/', '.')
                ->append('.'),
        )
            ->prefix($slug)
            ->middleware(static::getRouteMiddleware($panel))
            ->withoutMiddleware(static::getWithoutRouteMiddleware($panel))
            ->group(function () use ($panel) {
                foreach (static::getPages() as $name => $page) {
                    $page->registerRoute($panel)?->name($name);
                }
            });
    }

    public static function getRouteBaseName(?string $panel = null): string
    {
        $panel ??= UI::currentPanel()->getId();

        return (string) str(static::getSlug())
            ->replace('/', '.')
            ->prepend("streams.ui.{$panel}.");
    }

    public static function getSlug(): string
    {
        return static::$slug ?? (string) str(class_basename(static::class))
            ->kebab()
            ->slug();
    }

    public static function getRouteMiddleware(Panel $panel): string | array
    {
        return static::$middleware;
    }

    public static function getWithoutRouteMiddleware(Panel $panel): string | array
    {
        return static::$withoutMiddleware;
    }
}
