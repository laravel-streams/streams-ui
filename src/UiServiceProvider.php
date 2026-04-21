<?php

namespace Streams\Ui;

use Livewire\Livewire;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Lang;
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
            \Streams\Ui\Builders\Builder::class,
            \Streams\Ui\Support\Facades\UI::class,
            \Streams\Ui\Builders\Panels\Panel::class,
            \Streams\Ui\Support\Facades\Colors::class,
        ];
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../resources/config/ui.php',
            'streams.ui'
        );

        $this->app->singleton(\Streams\Ui\UiManager::class);
        $this->app->singleton(\Streams\Ui\Support\Facades\Notifications::class);

        $this->app->singleton('colors', \Streams\Ui\Colors\ColorManager::class);
        $this->app->singleton('actions', \Streams\Ui\Builders\Actions\ActionManager::class);
        $this->app->singleton('forms', \Streams\Ui\Builders\Forms\FormManager::class);
        $this->app->singleton('notifications', \Streams\Ui\Notifications\NotificationsManager::class);

        $this->app->alias(\Streams\Ui\UiManager::class, 'ui');
        $this->app->alias(\Streams\Ui\Colors\ColorManager::class, 'colors');
        $this->app->alias(\Streams\Ui\Notifications\NotificationsManager::class, 'notifications');
    }

    public function boot()
    {
        app(Router::class)->aliasMiddleware('panel', SetUpPanel::class);

        Integrator::aliases([
            'UI' => \Streams\Ui\Support\Facades\UI::class,
            'Actions' => \Streams\Ui\Support\Facades\Actions::class,
            'Forms' => \Streams\Ui\Support\Facades\Forms::class,
            'Notifications' => \Streams\Ui\Support\Facades\Notifications::class,
        ]);

        $this->publishes([
            __DIR__.'/../resources/streams' => base_path('streams'),
        ], 'laravel-streams');

        $this->publishes([
            __DIR__.'/../resources/config/ui.php' => config_path('streams/ui.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views/' => resource_path('views/vendor/ui'),
        ], 'ui');

        Assets::addPath('ui', 'vendor/streams/ui/resources');
        Images::addPath('ui', 'vendor/streams/ui/resources');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ui');

        Lang::addNamespace('ui', realpath(base_path('vendor/streams/ui/resources/lang')));

        Livewire::setPersistentMiddleware([
            \Streams\Ui\Http\Middleware\SetUpPanel::class,
        ]);

        Livewire::propertySynthesizer(\Streams\Ui\Support\EntrySynthesizer::class);

        $this->app->booted(function () {
            $this->loadRoutesFrom(__DIR__.'/../resources/routes/web.php');
        });
    }
}
