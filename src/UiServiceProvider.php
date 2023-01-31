<?php

namespace Streams\Ui;

use Livewire\Livewire;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Streams\Ui\Http\Middleware\LoadUi;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Streams;

class UiServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        if (env('APP_ENV') == 'testing') {
            $this->app->register(\Collective\Html\HtmlServiceProvider::class);
            $this->app->register(\Livewire\LivewireServiceProvider::class);

            AliasLoader::getInstance([
                'Html' => \Collective\Html\HtmlFacade::class,
                'Form' => \Collective\Html\FormFacade::class,
            ])->register();
        }

        $this->app->singleton(\Streams\Ui\Support\Breadcrumb::class);

        $this->app->singleton(\Streams\Ui\Support\UiManager::class);
        $this->app->alias(\Streams\Ui\Support\UiManager::class, 'ui');

        AliasLoader::getInstance([
            'UI' => \Streams\Ui\Support\Facades\UI::class,
        ])->register();

        $this->registerConfig();
        $this->registerStreams();

        $this->extendStream();
        $this->extendRouter();
        $this->extendStream();
        $this->extendField();
    }

    public function boot()
    {
        $this->extendUrl();
        $this->extendView();
        $this->extendLang();
        $this->extendAssets();

        $this->registerRoutes();
        $this->registerBladeDirectives();
        
        Livewire::component('form', \Streams\Ui\Components\Form::class);
        
        Livewire::component('button', \Streams\Ui\Components\Button::class);
        Livewire::component('buttons', \Streams\Ui\Components\Buttons::class);

        Livewire::component('field', \Streams\Ui\Components\Field::class);
        Livewire::component('fields', \Streams\Ui\Components\Fields::class);
        
        Livewire::component('text', \Streams\Ui\Components\Inputs\TextInput::class);
        Livewire::component('input', \Streams\Ui\Components\Inputs\TextInput::class);
        Livewire::component('textarea', \Streams\Ui\Components\Inputs\TextareaInput::class);
    }

    public function registerBladeDirectives()
    {
        Factory::macro('ui', function(string $name, array $attributes = []) {
            return UI::make($name, $attributes);
        });

        Blade::directive('ui', function ($parameters) {
            return "<?php echo \$__env->ui({$parameters}); ?>";
        });
    }

    /**
     * Register UI config.
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/ui.php', 'streams.ui');

        if (file_exists($config = __DIR__ . '/../../../../config/streams/ui.php')) {
            $this->mergeConfigFrom($config, 'streams.ui');
        }

        $this->publishes([
            __DIR__ . '/../resources/config/ui.php' => config_path('streams/ui.php'),
        ], 'config');
    }

    /**
     * Register UI streams.
     */
    protected function registerStreams()
    {
        $prefix  = __DIR__ . '/../resources/streams/';
        $streams = ['cp.navigation', 'cp.shortcuts', 'cp.themes'];

        foreach ($streams as $stream) {
            if (!Streams::exists($stream)) {
                Streams::load($prefix . $stream . '.json');
            }
        }

        $this->publishes([
            __DIR__ . '/../resources/streams/' => base_path('streams/'),
        ], 'streams');
    }

    /**
     * Register UI routes.
     */
    protected function registerRoutes()
    {
        if (!$this->app->routesAreCached()) {

            Route::streams('ui/{component}', [
                'csrf' => false,
                'middleware' => 'web',
                'uses'  => \Streams\Ui\Http\Controller\ComponentResponse::class,
            ]);

            Route::streams('/ui/{component}/{action}', [
                'verb' => 'get',
                'middleware' => 'web',
                'uses' => \Streams\Ui\Http\Controller\ComponentAction::class,
            ]);

            // Route::streams('ui/{stream}/{component}/{handle?}/{entry?}', [
            //     'ui.cp' => false,
            //     'csrf' => false,
            //     'uses'  => \Streams\Ui\Http\Controller\UiController::class,
            // ]);

            Route::prefix(Config::get('streams.ui.cp_prefix'))
                ->middleware(Config::get('streams.ui.cp_middleware'))
                ->group(function () {

                    if (file_exists($routes = base_path('routes/cp.php'))) {
                        include $routes;
                    }

                    // @todo Configure this later
                    $index  = '{section}';
                    $create = '{section}/create';
                    $edit   = '{section}/{entry}/edit';

                    Route::streams('/', [
                        'verb' => 'get',
                        'as'   => 'streams.ui.cp.home',
                        'uses' => \Streams\Ui\Http\Controller\UiController::class . '@index',
                    ]);

                    Route::streams($index, [
                        'verb'          => 'get',
                        'ui.cp'         => true,
                        'ui.cp_enabled' => true,
                        'ui.cp_enabled' => true,
                        'ui.component'  => 'table',
                        'as'            => 'streams.ui.cp.index',
                        'uses'          => \Streams\Ui\Http\Controller\UiController::class,
                    ]);

                    Route::streams($create, [
                        'verb'          => 'get',
                        'ui.cp'         => true,
                        'ui.cp_enabled' => true,
                        'entry'         => false,
                        'as'            => 'streams.ui.cp.create',
                        'ui.component'  => 'form',
                        'uses'          => \Streams\Ui\Http\Controller\UiController::class,
                    ]);

                    Route::streams($edit, [
                        'verb'          => 'get',
                        'ui.cp'         => true,
                        'ui.cp_enabled' => true,
                        'ui.cp_enabled' => true,
                        'ui.component'  => 'form',
                        'as'            => 'streams.ui.cp.edit',
                        'uses'          => \Streams\Ui\Http\Controller\UiController::class,
                    ]);
                });
        }
    }

    protected function extendRouter()
    {
        Route::macro('ui', function ($uri, $route) {

            Route::middleware([
                LoadUi::class,
            ])
                ->group(function () use ($uri, $route) {

                    $route['uses'] = Arr::get($route, 'uses') ?: \Streams\Ui\Http\Controller\UiController::class;

                    Route::streams($uri, $route);
                });
        });

        Route::macro('cp', function ($uri, $route) {

            Route::prefix(Config::get('streams.ui.cp_prefix'))
                ->middleware(Config::get('streams.ui.cp_middleware'))
                ->middleware([
                    LoadUi::class,
                ])
                ->group(function () use ($uri, $route) {

                    $route['uses'] = Arr::get($route, 'uses') ?: \Streams\Ui\Http\Controller\UiController::class;

                    $route['ui.cp']         = true;
                    $route['ui.cp_enabled'] = true;

                    Route::streams($uri, $route);
                });
        });
    }

    /**
     * Extend stream objects.
     */
    protected function extendStream()
    {
        Stream::macro('ui', function ($component, $handle = 'default', $attributes = []) {

            if (is_array($handle)) {
                $attributes = $handle;
                $handle     = 'default';
            }

            $configured = Arr::first(
                Arr::get($this->ui, Str::plural($component), []),
                fn ($config, $key) => Arr::get($config, 'handle') == $handle || $key == $handle
            );

            if (!$configured) {
                $configured = Arr::get($this->ui, $component, []);
            }

            $configured = Arr::undot($configured);

            $attributes = array_merge($attributes, $configured);
            
            $attributes['stream'] = $this;
            $attributes['handle'] = $handle;

            // @todo this needs work...
            if ($override = Arr::get($attributes, $component)) {
                $component = $override;
            }
            
            return UI::make($component, $attributes);
        });

        Stream::macro('form', function ($form = 'default', $attributes = []) {
            return $this->ui('form', $form, $attributes);
        });

        Stream::macro('table', function ($table = 'default', $attributes = []) {
            return $this->ui('table', $table, $attributes);
        });
    }

    /**
     * Extend stream fields.
     */
    protected function extendField()
    {
        $inputs = Config::get('streams.ui.input_types', []);

        foreach ($inputs as $abstract => $concrete) {
            $this->app->bind("streams.ui.input_types.{$abstract}", $concrete);
        }

        Field::macro('input', function (array $attributes = []) {

            $attributes = Arr::add($attributes, 'field', $this);

            $this->input = $this->input ?: [
                'type' => $this->type,
            ];

            $attributes = array_merge($attributes, (array) $this->input);

            return $this->once($this->stream->id . $this->handle . 'input', function () use ($attributes) {

                    Arr::pull($attributes, 'type');

                    if (!isset($this->input['type'])) {
                        throw new \Exception("Missing input type for field [{$this->handle}] in stream [{$this->stream->id}]");
                    }

                    return UI::make($this->input['type'], $attributes);
                }
            );
        });

        Field::addCallbackListener('initializing', function ($callbackData) {

            $attributes = $callbackData->get('attributes');

            if (!isset($attributes['input'])) {
                $attributes['input'] = [];
            }

            if (is_string($attributes['input'])) {
                $attributes['input'] = [
                    'type' => $attributes['input'],
                ];
            }

            if (is_string($attributes['type']) && strpos($attributes['type'], '|')) {
                [$attributes['type'], $attributes['input']['type']] = explode('|', $attributes['type']);
            }

            if (!isset($attributes['input']['type'])) {
                $attributes['input']['type'] = $attributes['type'];
            }

            $callbackData->put('attributes', $attributes);
        });
    }

    /**
     * Extend lang support.
     */
    protected function extendLang()
    {
        Lang::addNamespace('ui', realpath(base_path('vendor/streams/ui/resources/lang')));
    }

    /**
     * Extend URL support.
     */
    protected function extendUrl()
    {
        URL::macro('cp', function ($path, $extra = [], $secure = null) {
            return URL::to(
                Config::get('streams.ui.cp_prefix', 'cp') . rtrim('/' . $path, '/'),
                $extra,
                $secure
            );
        });
    }

    /**
     * Extend view support.
     */
    protected function extendView()
    {
        $this->callAfterResolving('view', function ($view) {
            if (
                isset($this->app->config['view']['paths']) &&
                is_array($this->app->config['view']['paths'])
            ) {
                foreach ($this->app->config['view']['paths'] as $viewPath) {
                    if (is_dir($appPath = $viewPath . '/vendor/streams/ui')) {
                        $view->addNamespace('ui', $appPath);
                    }
                }
            }
        });

        View::addNamespace('ui', __DIR__ . '/../resources/views');
    }

    /**
     * Extend asset support.
     */
    protected function extendAssets()
    {
        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/streams/ui'),
            __DIR__ . '/../resources/fonts'  => public_path('vendor/streams/ui/fonts'),
        ], 'public');

        // $this->publishes([
        //     __DIR__ . '/../resources/views' => resource_path('views/vendor/streams/ui'),
        // ], 'views');

        Assets::addPath('ui', 'vendor/streams/ui');

        Assets::register('streams.ui.css/theme.css');
        Assets::register('streams.ui.css/tailwind.css');
        Assets::register('streams.ui.css/variables.css');

        Assets::register('streams.ui.js/index.js');
    }
}
