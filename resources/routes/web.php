<?php

use Illuminate\Support\Facades\Route;
use Streams\Ui\Support\Facades\UI;

Route::name('streams.ui.')
    ->group(function () {

        foreach (UI::getPanels() as $panel) {

            $id = $panel->getId();
            $path = $panel->getPath();

            foreach ([null] as $domain) {

                if ($routes = $panel->getRoutes()) {
                    $routes($panel);
                }

                Route::domain($domain)
                    ->middleware($panel->getMiddleware())
                    ->name($id . '.')
                    ->prefix($path)
                    ->group(function () use ($panel) {
                        foreach ($panel->getPages() as $page) {
                            $page::routes($panel);
                        }
                    });
            }
        }
    });
