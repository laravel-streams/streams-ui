<?php

namespace Streams\Ui;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Input\Input;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Ui\Form\FormBuilder;
use Streams\Ui\Table\TableBuilder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
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
        //'UI' => \Streams\Ui\Support\Facades\UI::class
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
        \Streams\Ui\ControlPanel\ControlPanelBuilder::class => \Streams\Ui\ControlPanel\ControlPanelBuilder::class,

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
        $this->registerRoutes();

        $this->extendStream();
        $this->extendField();
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
        Streams::register([
            'handle' => 'cp.navigation',
            'source' => [
                'path' => 'streams/cp/navigation',
                'format' => 'json',
            ],
            'config' => [
                'abstract' => 'Streams\\Ui\\ControlPanel\\Component\\Navigation\\Section',
            ],
            'fields' => [
                'title' => 'string',
                'parent' => [
                    'type' => 'relationship',
                    'related' => 'cp.navigation',
                ],
            ],
        ]);

        Streams::register([
            'handle' => 'cp.shortcuts',
            'source' => [
                'path' => 'streams/cp/shortcuts',
                'format' => 'json',
            ],
            'config' => [
                'abstract' => 'Streams\\Ui\\ControlPanel\\Component\\Shortcut\\Shortcut',
            ],
            'fields' => [
                'title' => 'string',
                'icon' => 'string',
                'svg' => 'string',
            ],
        ]);

        Streams::register([
            'handle' => 'cp.theme',
            'source' => [
                'file' => 'streams/cp/theme.json',
                'type' => 'file',
            ],
            'fields' => [
                'id' => [
                    'type' => 'slug',
                    'required' => true,
                ],
                'spacing' => [
                    'type' => 'decimal',
                    'required' => true,
                ],
            ],
        ]);
    }

    /**
     * Register UI routes.
     */
    protected function registerRoutes()
    {
        if (!$this->app->routesAreCached()) {

            Route::streams(Config::get('streams.cp.prefix'), [
                'verb' => 'get',
                'as' => 'ui::cp.home',
                'uses' => '\Streams\Ui\Http\Controller\UiController@index',
            ]);

            Route::prefix(Config::get('streams.ui.cp.prefix'))->middleware(['cp'])->group(function () {

                /**
                 * Route navigation first.
                 */
                Streams::entries('cp.navigation')->get()
                    ->filter(function ($section) {
                        return $section->route;
                    })->each(function ($section) {
                        Route::streams(Arr::get($section->route, 'uri', $section->id), array_merge([
                            'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                        ], $section->route));
                    });

                // @todo Configure this later
                $index = '{stream}';
                $create = '{stream}/create';
                $edit = '{stream}/{entry}/edit';

                $table = 'ui/{stream}/table/{table?}';
                $form = 'ui/{stream}/form/{form?}';

                Route::streams($index, [
                    'verb' => 'get',
                    'ui.cp' => true,
                    'entry' => false,
                    'as' => 'ui::cp.index',
                    'ui.component' => 'table',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                Route::streams($create, [
                    'verb' => 'get',
                    'ui.cp' => true,
                    'entry' => false,
                    'as' => 'ui::cp.create',
                    'ui.component' => 'form',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                Route::streams($edit, [
                    'verb' => 'get',
                    'ui.cp' => true,
                    'as' => 'ui::cp.edit',
                    'ui.component' => 'form',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                Route::streams($table, [
                    'ui.cp' => false,
                    //'as' => 'ui::cp.edit',
                    'ui.component' => 'table',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                Route::streams($form, [
                    'ui.cp' => false,
                    //'as' => 'ui::cp.edit',
                    'ui.component' => 'form',
                    'uses' => '\Streams\Ui\Http\Controller\UiController@handle',
                ]);

                if (file_exists($routes = base_path('routes/cp.php'))) {
                    include $routes;
                }
            });
        }
    }

    /**
     * Extend stream objects.
     */
    protected function extendStream()
    {
        Stream::macro('form', function ($form = 'default', $attributes = []) {

            if (is_array($form)) {
                $attributes = $form;
                $form = 'default';
            }

            if (!$configured = Arr::get($this->ui, 'forms.' . $form)) {
                $configured = Arr::get($this->ui, 'form', []);
            }

            $configured = Arr::undot($configured);

            $attributes = array_merge($attributes, $configured);

            $attributes['stream'] = $this;
            $attributes['handle'] = $form;

            return new FormBuilder($attributes);
        });

        Stream::macro('table', function ($table = 'default', $attributes = []) {

            /** @var \Streams\Core\Stream\Stream $this */
            if (is_array($table)) {
                $attributes = $table;
                $table = 'default';
            }

            if (!$configured = Arr::get($this->ui, 'tables.' . $table)) {
                $configured = Arr::get($this->ui, 'table', []);
            }

            $attributes = array_merge($attributes, $configured);

            $attributes['stream'] = $this;
            $attributes['handle'] = $table;

            return new TableBuilder($attributes);
        });
    }

    /**
     * Extend stream fields.
     */
    protected function extendField()
    {
        Field::macro('input', function () {

            $attributes = ['field' => $this];

            $input = Str::camel('new_' . ($this->input ?: 'string') . '_input');

            return $this->$input($attributes);
        });

        $inputs = Config::get('streams.ui.inputs');

        foreach ($inputs as $abstract => $concrete) {
            $this->app->bind("streams.ui.input.{$abstract}", $concrete);
        }

        Field::macro('input', function (array $attributes = []) {

            return $this->remember($this->handle . '.' . $this->type . '.' . md5(json_encode($attributes)), function () use ($attributes) {

                $attributes['field'] = Arr::get($attributes, 'field', $this);

                if ($this->input instanceof Input) {
                    return $this->input;
                }

                return App::make("streams.ui.input.{$this->input['type']}", [
                    'attributes' => $attributes,
                ]);
            });
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
                Config::get('streams.cp.prefix', 'cp') . $path,
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
        Assets::addPath('ui', 'vendor/streams/ui');
    }
}
