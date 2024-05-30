<?php

namespace Streams\Ui;

use Livewire\Livewire;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Integrator;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Ui\Http\Middleware\SetUpPanel;

class UiServiceProvider extends ServiceProvider
{
    public function provides(): array
    {
        return [
            \Streams\Ui\Panels\Panel::class,
            \Streams\Ui\Builders\Builder::class,
            \Streams\Ui\Support\Facades\UI::class,
            \Streams\Ui\Support\Facades\Colors::class,
        ];
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../resources/config/ui.php',
            'streams.ui'
        );

        $this->app->singleton(\Streams\Ui\UiManager::class);
        
        $this->app->singleton('colors', \Streams\Ui\Colors\ColorManager::class);
        $this->app->singleton('breadcrumbs', \Illuminate\Support\Collection::class);
    }

    public function boot()
    {
        $this->app->alias(\Streams\Ui\UiManager::class, 'ui');
        $this->app->alias(\Streams\Ui\Colors\ColorManager::class, 'colors');
        
        app(Router::class)->aliasMiddleware('panel', SetUpPanel::class);

        Integrator::aliases([
            'UI' => \Streams\Ui\Support\Facades\UI::class,
        ]);

        $this->publishes([
            __DIR__ . '/../resources/streams' => base_path('streams'),
        ], 'laravel-streams');

        $this->publishes([
            __DIR__ . '/../resources/config/ui.php' => config_path('streams/ui.php'),
        ], 'config');

        Assets::addPath('ui', 'vendor/streams/ui/resources');
        Images::addPath('ui', 'vendor/streams/ui/resources');

        View::addNamespace('ui', __DIR__ . '/../resources/views');

        Lang::addNamespace('ui', realpath(base_path('vendor/streams/ui/resources/lang')));

        Livewire::setPersistentMiddleware([
            \Streams\Ui\Http\Middleware\SetUpPanel::class,
        ]);

        Livewire::propertySynthesizer(\Streams\Ui\Support\EntrySynthesizer::class);

        // foreach (config('streams.ui.components') as $name => $class) {
        //     UI::component($name, $class);
        // }

        // foreach (config('streams.ui.livewire') as $name => $class) {
        //     Livewire::component($name, $class);
        // }

        $this->app->booted(function () {

            $this->loadRoutesFrom(__DIR__ . '/../resources/routes/web.php');

            // foreach (config('streams.ui.components') as $name => $class) {
            //     Blade::component($name, BladeComponent::class);
            // }
        });
    }
}
