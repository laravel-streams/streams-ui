<?php

use Illuminate\Support\Facades\Route;
use Streams\Ui\Support\Facades\UI;

Route::name('streams.ui.')
    ->group(function () {

        foreach (UI::getPanels() as $panel) {

            $name = $panel->name;
            $path = $panel->path;

            foreach ([null] as $domain) {

                if ($routes = $panel->getRoutes()) {
                    $routes($panel);
                }

                Route::domain($domain)
                    ->middleware($panel->getMiddleware())
                    ->name($name . '.')
                    ->prefix($path)
                    ->group(function () use ($panel) {
                            
                            foreach ($panel->getComponents() as $component) {
                                $component::routes($panel);
                            }
                    });
            }
        }
    });
