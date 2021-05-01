<?php

namespace Streams\Ui;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Input\Input;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Streams\Ui\Http\Middleware\LoadUi;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Streams;

class UiServiceProvider extends ServiceProvider
{

    /**
     * The class aliases.
     *
     * @var array
     */
    public $aliases = [
        'ui' => \Streams\Ui\Support\Facades\UI::class
    ];

    /**
     * The class bindings.
     *
     * @var array
     */
    public $bindings = [
        //\Streams\Core\Stream\Contract\StreamRepositoryInterface::class  => \Streams\Core\Stream\StreamRepository::class,
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [
        \Streams\Ui\Support\Breadcrumb::class => \Streams\Ui\Support\Breadcrumb::class,
        
        // Get rid of these registries and register something to IoC like streams.ui.button.save using internal naming - do whatever you want otherwise.
        \Streams\Ui\Button\ButtonRegistry::class => \Streams\Ui\Button\ButtonRegistry::class,
        \Streams\Ui\Table\Component\View\ViewRegistry::class => \Streams\Ui\Table\Component\View\ViewRegistry::class,
        \Streams\Ui\Table\Component\Filter\FilterRegistry::class => \Streams\Ui\Table\Component\Filter\FilterRegistry::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerStreams();
        $this->registerConfig();

        $this->extendRouter();
        $this->extendStream();
        $this->extendField();

        $this->registerRoutes();
    }

    public function boot()
    {
        $this->extendUrl();
        $this->extendView();
        $this->extendLang();
        $this->extendAssets();
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
            __DIR__ . '/../resources/config/ui.php' => config_path('streams/ui.php')
        ], 'config');
    }

    /**
     * Register UI streams.
     */
    protected function registerStreams()
    {
        $prefix = __DIR__ . '/../resources/streams/';
        $streams = ['cp.navigation', 'cp.shortcuts', 'cp.themes'];

        foreach ($streams as $stream) {
            if (!Streams::has($stream)) {
                Streams::load($prefix . $stream . '.json');
            }
        }

        $this->publishes([
            __DIR__ . '/../resources/streams/' => base_path('streams/')
        ], 'streams');
    }

    /**
     * Register UI routes.
     */
    protected function registerRoutes()
    {
        if (!$this->app->routesAreCached()) {

            Route::streams(Config::get('streams.ui.cp_prefix'), [
                'verb' => 'get',
                'as' => 'ui::cp.home',
                'uses' => '\Streams\Ui\Http\Controller\UiController@index',
            ]);

            Route::prefix(Config::get('streams.ui.cp_prefix'))->middleware(Config::get('streams.ui.cp_middleware'))->group(function () {

                /**
                 * Load route file first.
                 */
                if (file_exists($routes = base_path('routes/cp.php'))) {
                    include $routes;
                }

                /**
                 * Route navigation next.
                 */
                // Streams::entries('cp.navigation')->get()
                //     ->filter(function ($section) {
                //         return $section->route;
                //     })->each(function ($section) {
                //         Route::streams(Arr::get($section->route, 'uri', $section->id), array_merge([
                //             'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                //         ], $section->route));
                //     });

                // @todo Configure this later
                $index = '{section}';
                $create = '{section}/create';
                $edit = '{section}/{entry}/edit';

                $component = 'ui/{stream}/{component}/{handle?}';

                Route::streams($index, [
                    'verb' => 'get',
                    'ui.cp' => true,
                    'ui.cp_enabled' => true,
                    'entry' => false,
                    'as' => 'ui::cp.index',
                    'ui.component' => 'table',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                Route::streams($create, [
                    'verb' => 'get',
                    'ui.cp' => true,
                    'ui.cp_enabled' => true,
                    'entry' => false,
                    'as' => 'ui::cp.create',
                    'ui.component' => 'form',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                Route::streams($edit, [
                    'verb' => 'get',
                    'ui.cp' => true,
                    'ui.cp_enabled' => true,
                    'as' => 'ui::cp.edit',
                    'ui.component' => 'form',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                Route::streams($component, [
                    'ui.cp' => false,
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
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

                    $route['uses'] = Arr::get($route, 'uses') ?: '\Streams\Ui\Http\Controller\UiController';

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

                    $route['uses'] = Arr::get($route, 'uses') ?: '\Streams\Ui\Http\Controller\UiController';

                    $route['ui.cp'] = true;
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
                $handle = 'default';
            }

            if (!$configured = Arr::get($this->ui, Str::plural($component) . '.' . $handle)) {
                $configured = Arr::get($this->ui, $component, []);
            }

            $configured = Arr::undot($configured);

            $attributes = array_merge($attributes, $configured);

            $attributes['stream'] = $this;
            $attributes['handle'] = $handle;

            if (!$builder = Arr::pull($attributes, 'builder')) {

                $class = Str::studly($component);

                $builder = "Streams\Ui\\{$class}\\{$class}Builder";
            }

            return new $builder($attributes);
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

            return $this->once($this->stream->handle . '.' . $this->handle . '.' . $this->type, function () use ($attributes) {

                $attributes['field'] = Arr::get($attributes, 'field', $this);

                $attributes = $attributes + $this->input;

                Arr::pull($attributes, 'type');

                if ($this->input instanceof Input) {
                    return $this->input;
                }

                return App::make("streams.ui.input_types.{$this->input['type']}", [
                    'attributes' => $attributes,
                ]);
            });
        });

        Field::when('initializing', function ($callbackData) {
            
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
                list($attributes['type'], $attributes['input']['type']) = explode('|', $attributes['type']);
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
        View::addNamespace('ui', base_path('vendor/streams/ui/resources/views'));
    }

    /**
     * Extend asset support.
     */
    protected function extendAssets()
    {
        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/streams/ui'),
        ], 'public');

        Assets::addPath('ui', 'vendor/streams/ui');

        Assets::register('ui::css/theme.css');
        Assets::register('ui::css/tailwind.css');
        Assets::register('ui::css/variables.css');

        Assets::register('ui::js/index.js');
    }
}
