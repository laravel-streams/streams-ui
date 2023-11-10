<?php

namespace Streams\Ui\Pages\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Panels\Panel;
use Illuminate\Support\Facades\Route;

trait HasRoutes
{
    protected static ?string $slug = null;

    protected static string | array $middleware = [];

    protected static string | array $withoutMiddleware = [];

    public static function routes(Panel $panel): void
    {
        $slug = static::getSlug();

        Route::get("/{$slug}", static::class)
            ->middleware(static::getRouteMiddleware($panel))
            ->withoutMiddleware(static::getRouteWithoutMiddleware($panel))
            ->name(Str::replace('/', '.', $slug));
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

    public static function getRouteWithoutMiddleware(Panel $panel): string | array
    {
        return static::$withoutMiddleware;
    }
}
