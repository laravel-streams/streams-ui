<?php

namespace Streams\Ui;

use Streams\Ui\Input\Date;
use Streams\Ui\Input\File;
use Streams\Ui\Input\Slug;
use Streams\Ui\Input\Time;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Input\Color;
use Streams\Ui\Input\Image;
use Streams\Ui\Input\Input;
use Streams\Ui\Input\Radio;
use Streams\Ui\Input\Range;
use Streams\Ui\Input\Select;
use Streams\Ui\Input\Toggle;
use Streams\Core\Field\Field;
use Streams\Ui\Input\Decimal;
use Streams\Ui\Input\Integer;
use Streams\Ui\Input\Datetime;
use Streams\Ui\Input\Markdown;
use Streams\Ui\Input\Textarea;
use Streams\Core\Stream\Stream;
use Streams\Ui\Form\FormBuilder;
use Streams\Core\Field\FieldType;
use Streams\Ui\Input\Relationship;
use Streams\Ui\Table\TableBuilder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Streams;

/**
 * Class StreamsServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
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
        \Streams\Ui\Icon\IconRegistry::class => \Streams\Ui\Icon\IconRegistry::class,
        \Streams\Ui\Support\Breadcrumb::class => \Streams\Ui\Support\Breadcrumb::class,
        \Streams\Ui\Button\ButtonRegistry::class => \Streams\Ui\Button\ButtonRegistry::class,
        \Streams\Ui\ControlPanel\ControlPanelBuilder::class => \Streams\Ui\ControlPanel\ControlPanelBuilder::class,
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
        $this->extendView();

        $this->mergeConfigFrom(__DIR__ . '/../resources/config/cp.php', 'streams.cp');

        Streams::register([
            'handle' => 'cp.navigation',
            'source' => [
                'path' => 'streams/cp/navigation',
                'format' => 'json',
            ],
            'config' => [
                'prototype' => 'Streams\\Ui\\ControlPanel\\Component\\Navigation\\Section',
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
                'prototype' => 'Streams\\Ui\\ControlPanel\\Component\\Shortcut\\Shortcut',
            ],
            'fields' => [
                'title' => 'string',
                'icon' => 'string',
                'svg' => 'string',
            ],
        ]);

        if (!$this->app->routesAreCached()) {

            Route::streams(Config::get('streams.cp.prefix'), [
                'verb' => 'get',
                'as' => 'ui::cp.home',
                'uses' => '\Streams\Ui\Http\Controller\UiController@index',
            ]);

            Route::prefix(Config::get('streams.cp.prefix'))->middleware(['cp'])->group(function () {

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
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            base_path('vendor/streams/ui/resources/public')
            => public_path('vendor/streams/ui')
        ], ['public']);

        $this->extendLang();
        $this->extendAssets();

        $this->extendStream();
        $this->extendField();
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

        $inputs = [
            'text' => Input::class,
            'hash' => Input::class,
            'input' => Input::class,
            'string' => Input::class,

            'date' => Date::class,
            'time' => Time::class,
            'datetime' => Datetime::class,

            'slug' => Slug::class,

            'color' => Color::class,
            'radio' => Radio::class,
            'range' => Range::class,

            'select' => Select::class,

            'integer' => Integer::class,
            'decimal' => Decimal::class,

            'textarea' => Textarea::class,
            'markdown' => Markdown::class,

            'file' => File::class,
            'image' => Image::class,

            'relationship' => Relationship::class,

            'boolean' => Toggle::class,
        ];

        foreach ($inputs as $abstract => $concrete) {
            $this->app->bind("streams.ui.input.{$abstract}", $concrete);
        }

        Field::macro('input', function (array $attributes = []) {

            $attributes['field'] = Arr::get($attributes, 'field', $this);

            if ($this->input instanceof Input) {
                return $this->input;
            }

            return App::make("streams.ui.input.{$this->input['type']}", [
                'attributes' => $attributes,
            ]);
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
