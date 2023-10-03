<?php

namespace Streams\Ui;

use Illuminate\View\Factory;
use Illuminate\Support\Collection;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Integrator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Streams\Ui\Support\BladeComponent;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;

class UiServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('breadcrumbs', Collection::class);

        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/streams/ui'),
        ], 'laravel-assets');

        $this->publishes([
            __DIR__ . '/../resources/streams' => public_path('streams'),
        ], 'laravel-assets');

        $this->registerConfig();
        $this->registerAdmin();

        $this->app->singleton(\Streams\Ui\UiManager::class);
        $this->app->alias(\Streams\Ui\UiManager::class, 'ui');

        Integrator::aliases([
            'UI' => \Streams\Ui\Support\Facades\UI::class,
        ]);

        Factory::macro('ui', function(string $name, array $attributes = []) {
            return UI::make($name, $attributes);
        });

        Blade::directive('ui', function ($parameters) {
            return "<?php echo \$__env->ui({$parameters}); ?>";
        });

        foreach (config('streams.ui.components') as $name => $class) {
            UI::component($name, $class);
        }
    }

    public function boot()
    {
        Assets::addPath('ui', 'vendor/streams/ui/resources');
        Images::addPath('ui', 'vendor/streams/ui/resources');

        View::addNamespace('ui', __DIR__ . '/../resources/views');

        Lang::addNamespace('ui', realpath(base_path('vendor/streams/ui/resources/lang')));

        $this->app->booted(function() {
            foreach (UI::getComponents() as $name => $class) {
                Blade::component($name, BladeComponent::class);
            }
        });
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/ui.php', 'streams.ui');

        $this->publishes([
            __DIR__ . '/../resources/config/ui.php' => config_path('streams/ui.php'),
        ], 'config');
    }

    protected function registerAdmin()
    {
        if (!Config::get('streams.ui.admin.enabled')) {
            return;
        }

        Route::prefix(Config::get('streams.ui.admin.prefix'))
            ->middleware(Config::get('streams.ui.admin.middleware'))
            ->group(function () {

                Route::get('/', Config::get('streams.ui.admin.default'));

                Route::any('/logout', \Streams\Ui\Http\Controllers\Logout::class);
    
                Route::get('/{stream}/{action?}/{entry?}', \Streams\Ui\Components\Admin\AdminAction::class);
            });

        Route::any('streams/ui/{component}/{method?}', \Streams\Ui\Http\Controllers\ComponentAction::class);
    }
}
