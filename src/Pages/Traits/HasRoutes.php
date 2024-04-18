<?php

namespace Streams\Ui\Pages\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Panels\Panel;
use Illuminate\Routing\Route;
use Streams\Ui\Pages\PageRouter;
use Illuminate\Support\Facades\Route as RouteFacade;

trait HasRoutes
{
    protected static ?string $slug = null;

    protected static ?string $routeName = null;

    protected static string | array $middleware = [];

    protected static string | array $withoutMiddleware = [];

    public static function routes(Panel $panel): void
    {
        $slug = static::getSlug();

        RouteFacade::get("/{$slug}", static::class)
            ->middleware(static::getRouteMiddleware($panel) ?: ['web'])
            ->withoutMiddleware(static::getWithoutRouteMiddleware($panel))
            ->name(static::$routeName ?: Str::replace('/', '.', $slug));
    }

    public static function route(string $path): PageRouter
    {
        return new PageRouter(
            static::class,
            fn (Panel $panel): Route => RouteFacade::get($path, static::class)
                ->middleware(static::getRouteMiddleware($panel))
                ->withoutMiddleware(static::getWithoutRouteMiddleware($panel)),
        );
    }

    public static function getSlug(): string
    {
        return static::$slug ?? (string) str(class_basename(static::class))
            ->kebab()
            ->slug();
    }

    public static function getRouteMiddleware(Panel $panel): string | array
    {
        return [
            //...(static::isEmailVerificationRequired($panel) ? [static::getEmailVerifiedMiddleware($panel)] : []),
            //...(static::isTenantSubscriptionRequired($panel) ? [static::getTenantSubscribedMiddleware($panel)] : []),
            ...Arr::wrap(static::$middleware),
        ];
    }

    public static function getWithoutRouteMiddleware(Panel $panel): string | array
    {
        return static::$withoutMiddleware;
    }
}
