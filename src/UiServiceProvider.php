<?php

namespace Streams\Ui;

use Illuminate\View\Factory;
use Streams\Core\Field\Field;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;

class UiServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        // This is a hack to get the tests to pass.
        // @todo Remove this.
        if (App::environment('testing')) {
            $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        }

        $this->app->singleton(\Streams\Ui\Support\UiManager::class);
        $this->app->alias(\Streams\Ui\Support\UiManager::class, 'ui');

        AliasLoader::getInstance([
            'UI' => \Streams\Ui\Support\Facades\UI::class,
        ])->register();

        $this->registerConfig();

        Field::macro('input', $this->app[\Streams\Ui\Support\Macros\FieldInput::class]());
    }

    public function boot()
    {
        $this->registerRoutes();

        View::addNamespace('ui', __DIR__ . '/../resources/views');

        Lang::addNamespace('ui', realpath(base_path('vendor/streams/ui/resources/lang')));
        
        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/streams/ui'),
        ], 'public');

        Assets::addPath('ui', 'vendor/streams/ui');

        Assets::register('streams.ui.css/theme.css');
        Assets::register('streams.ui.css/tailwind.css');
        Assets::register('streams.ui.css/variables.css');

        Assets::register('streams.ui.js/index.js');

        Factory::macro('ui', function(string $name, array $attributes = []) {
            return UI::make($name, $attributes);
        });

        Blade::directive('ui', function ($parameters) {
            return "<?php echo \$__env->ui({$parameters}); ?>";
        });
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/ui.php', 'streams.ui');

        if (file_exists($config = base_path('config/streams/ui.php'))) {
            $this->mergeConfigFrom($config, 'streams.ui');
        }

        $this->publishes([
            __DIR__ . '/../resources/config/ui.php' => config_path('streams/ui.php'),
        ], 'config');
    }

    /**
     * Register UI routes.
     */
    protected function registerRoutes()
    {
        Route::post('streams/ui/{component}/{action}', [
            'uses'  => \Streams\Ui\Http\Controller\ComponentAction::class,
        ]);
    }
}
