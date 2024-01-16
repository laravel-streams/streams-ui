<?php

namespace Streams\Ui;

use Livewire\Livewire;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Integrator;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Ui\Http\Middleware\SetUpPanel;
use Illuminate\Contracts\Support\DeferrableProvider;

class UiServiceProvider extends ServiceProvider //implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            \Streams\Ui\Builders\Builder::class,
            \Streams\Ui\Panels\Panel::class,
            \Streams\Ui\Builders\Facades\UI::class,
        ];
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../resources/config/ui.php',
            'streams.ui'
        );

        $this->app->singleton(\Streams\Ui\UiManager::class);

        $this->app->singleton('breadcrumbs', Collection::class);
    }

    public function boot()
    {
        $this->app->alias(\Streams\Ui\UiManager::class, 'ui');

        app(Router::class)->aliasMiddleware('panel', SetUpPanel::class);

        Integrator::aliases([
            'UI' => \Streams\Ui\Builders\Facades\UI::class,
        ]);

        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/streams/ui'),
        ], 'laravel-assets');

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
