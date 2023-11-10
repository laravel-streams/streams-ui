<?php

namespace Streams\Ui;

use Illuminate\Routing\Router;
use Livewire\Livewire;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Integrator;
use Illuminate\Support\Facades\Blade;
use Streams\Ui\Support\BladeComponent;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Ui\Http\Middleware\SetUpPanel;

class UiServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('breadcrumbs', Collection::class);

        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/streams/ui'),
        ], 'laravel-assets');

        $this->publishes([
            __DIR__ . '/../resources/streams' => base_path('streams'),
        ], 'laravel-streams');

        $this->registerConfig();

        $this->app->singleton(\Streams\Ui\UiManager::class);
        $this->app->alias(\Streams\Ui\UiManager::class, 'ui');

        app(Router::class)->aliasMiddleware('panel', SetUpPanel::class);

        // foreach (config('streams.ui.components') as $name => $class) {
        //     UI::component($name, $class);
        // }

        foreach (config('streams.ui.livewire') as $name => $class) {
            Livewire::component($name, $class);
        }
    }

    public function boot()
    {
        Integrator::aliases([
            'UI' => \Streams\Ui\Support\Facades\UI::class,
        ]);
        
        Assets::addPath('ui', 'vendor/streams/ui/resources');
        Images::addPath('ui', 'vendor/streams/ui/resources');

        View::addNamespace('ui', __DIR__ . '/../resources/views');

        Lang::addNamespace('ui', realpath(base_path('vendor/streams/ui/resources/lang')));

        Livewire::setPersistentMiddleware([
            \Streams\Ui\Http\Middleware\SetUpPanel::class,
        ]);

        $this->app->booted(function() {
            foreach (config('streams.ui.components') as $name => $class) {
                Blade::component($name, BladeComponent::class);
            }
        });

        $this->loadRoutesFrom(__DIR__ . '/../resources/routes/web.php');
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/ui.php', 'streams.ui');

        $this->publishes([
            __DIR__ . '/../resources/config/ui.php' => config_path('streams/ui.php'),
        ], 'config');
    }
}
