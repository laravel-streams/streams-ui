<?php

use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Route;

Route::name('streams.ui.')
    ->group(function () {

        foreach (UI::getPanels() as $panel) {

            $id = $panel->getId();
            $path = $panel->getPath();

            foreach ($panel->getDomains() ?: [null] as $domain) {

                Route::domain($domain)
                    ->middleware($panel->getMiddleware())
                    ->name($id.'.')
                    ->prefix($path)
                    ->group(function () use ($panel) {

                        Route::get('/', function () use ($panel) {
                            $url = $panel->getHomeUrl() ?? $panel->getUrl();

                            abort_if($url === null, 404);

                            return redirect($url);
                        })->name('home');

                        if ($routes = $panel->getRoutes()) {
                            $routes($panel);
                        }

                        foreach ($panel->getPages() as $page) {
                            $page::routes($panel);
                        }

                        foreach ($panel->getResources() as $resource) {
                            $resource::routes($panel);
                        }
                    });
            }
        }
    });
