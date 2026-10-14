<?php

namespace Streams\Ui\Routing;

use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Route;
use Streams\Ui\Builders\Panels\Panel;

class RegisterPanelRoutes
{
    public static function register(): void
    {
        foreach (UI::getPanels() as $panel) {
            static::registerPanel($panel);
        }
    }

    public static function registerPanel(Panel $panel): void
    {
        $id = $panel->getId();
        $path = $panel->getPath();
        $domains = $panel->getDomains();

        foreach ($domains === [] ? [null] : $domains as $domain) {
            Route::domain($domain)
                ->middleware($panel->getMiddleware())
                ->name("streams.ui.{$id}.")
                ->prefix($path)
                ->group(function () use ($panel) {
                    if ($routes = $panel->getRoutes()) {
                        static::callRoutes($routes, $panel);
                    }

                    Route::get('/', function () use ($panel) {
                        $target = $panel->getHomeUrl() ?: $panel->getUrl();

                        if (! filled($target)) {
                            abort(404);
                        }

                        return redirect()->to($target);
                    })->name('home');

                    foreach ($panel->getPages() as $page) {
                        $page::routes($panel);
                    }

                    foreach ($panel->getResources() as $resource) {
                        $resource::routes($panel);
                    }
                });
        }

        Route::getRoutes()->refreshNameLookups();
    }

    protected static function callRoutes(\Closure $routes, Panel $panel): void
    {
        $parameters = (new \ReflectionFunction($routes))->getNumberOfParameters();

        if ($parameters > 0) {
            $routes($panel);

            return;
        }

        $routes();
    }
}
