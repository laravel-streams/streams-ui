<?php

namespace Streams\Ui;

use Livewire\Livewire;
use Illuminate\Routing\Router;
use Streams\Ui\Builders\Builder;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Colors\ColorManager;
use Illuminate\Support\Facades\Lang;
use Streams\Core\Support\Integrator;
use Streams\Ui\Builders\Panels\Panel;
use Streams\Ui\Support\Facades\Forms;
use Streams\Ui\Support\Facades\Colors;
use Streams\Ui\Support\Facades\Tables;
use Illuminate\Support\ServiceProvider;
use Streams\Ui\Support\Facades\Actions;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Ui\Support\EntrySynthesizer;
use Streams\Ui\Builders\Forms\FormManager;
use Streams\Ui\Http\Middleware\SetUpPanel;
use Streams\Ui\Builders\Tables\TableManager;
use Streams\Ui\Support\Facades\Notifications;
use Streams\Ui\Builders\Actions\ActionManager;
use Streams\Ui\Notifications\NotificationsManager;

class UiServiceProvider extends ServiceProvider
{
    public function provides(): array
    {
        return [
            Builder::class,
            UI::class,
            Panel::class,
            Colors::class,
        ];
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../resources/config/ui.php',
            'streams.ui'
        );

        $this->app->singleton(UiManager::class);
        $this->app->singleton(Notifications::class);

        $this->app->singleton('colors', ColorManager::class);
        $this->app->singleton('forms', FormManager::class);
        $this->app->singleton('tables', TableManager::class);
        $this->app->singleton('actions', ActionManager::class);
        $this->app->singleton('notifications', NotificationsManager::class);

        $this->app->alias(UiManager::class, 'ui');
        $this->app->alias(ColorManager::class, 'colors');
        $this->app->alias(NotificationsManager::class, 'notifications');
    }

    public function boot()
    {
        app(Router::class)->aliasMiddleware('panel', SetUpPanel::class);

        Integrator::aliases([
            'UI' => UI::class,
            'Forms' => Forms::class,
            'Tables' => Tables::class,
            'Actions' => Actions::class,
            'Notifications' => Notifications::class,
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
            SetUpPanel::class,
        ]);

        Livewire::propertySynthesizer(EntrySynthesizer::class);

        $this->app->booted(function () {
            $this->loadRoutesFrom(__DIR__.'/../resources/routes/web.php');
        });
    }
}
