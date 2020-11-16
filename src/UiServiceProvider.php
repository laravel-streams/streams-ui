<?php

namespace Streams\Ui;

use Streams\Ui\Input\Date;
use Streams\Ui\Input\Slug;
use Streams\Ui\Input\Time;
use Illuminate\Support\Arr;
use Streams\Ui\Input\Color;
use Streams\Ui\Input\Input;
use Streams\Ui\Input\Radio;
use Streams\Ui\Input\Range;
use Streams\Ui\Input\Toggle;
use Streams\Ui\Input\Select;
use Streams\Core\Field\Field;
use Streams\Ui\Input\Integer;
use Streams\Ui\Input\Datetime;
use Streams\Ui\Input\Markdown;
use Streams\Ui\Input\Textarea;
use Streams\Core\Stream\Stream;
use Streams\Ui\Form\FormBuilder;
use Streams\Ui\Table\TableBuilder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
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

        $this->app->bind('streams.input_types.text', Input::class);
        $this->app->bind('streams.input_types.hash', Input::class);
        $this->app->bind('streams.input_types.input', Input::class);
        $this->app->bind('streams.input_types.string', Input::class);

        $this->app->bind('streams.input_types.date', Date::class);
        $this->app->bind('streams.input_types.time', Time::class);
        $this->app->bind('streams.input_types.datetime', Datetime::class);

        $this->app->bind('streams.input_types.slug', Slug::class);
        $this->app->bind('streams.input_types.color', Color::class);
        $this->app->bind('streams.input_types.radio', Radio::class);
        $this->app->bind('streams.input_types.range', Range::class);
        $this->app->bind('streams.input_types.select', Select::class);
        $this->app->bind('streams.input_types.integer', Integer::class);
        $this->app->bind('streams.input_types.textarea', Textarea::class);
        $this->app->bind('streams.input_types.markdown', Markdown::class);
        
        $this->app->bind('streams.input_types.relationship', Relationship::class);

        $this->app->bind('streams.input_types.boolean', Toggle::class);

        Streams::register([
            'handle' => 'cp.navigation',
            'source' => [
                'path' => 'streams/cp/navigation',
                'format' => 'json',
            ],
            'config' => [
                'prototype' => 'Streams\\Ui\\ControlPanel\\Component\\Navigation\\NavigationLink',
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

        Route::prefix(Config::get('streams.cp.prefix'))->middleware(['cp'])->group(function () {

            Route::streams('{stream}', [ // @todo Configure this later
                'entry' => false,
                'as' => 'ui::cp.index',
                'ui.component' => 'table',
                'uses' => '\Streams\Ui\Http\Controller\CpController@handle',
            ]);

            Route::streams('{stream}/create', [ // @todo Configure this later
                'entry' => false,
                'as' => 'ui::cp.create',
                'ui.component' => 'form',
                'uses' => '\Streams\Ui\Http\Controller\CpController@handle',
            ]);

            Route::streams('{stream}/{entry}/edit', [ // @todo Configure this later
                'as' => 'ui::cp.edit',
                'ui.component' => 'form',
                'uses' => '\Streams\Ui\Http\Controller\CpController@handle',
            ]);

            if (file_exists($routes = base_path('routes/cp.php'))) {
                include $routes;
            }
        });
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

            $attributes = array_merge($attributes, $configured);

            $attributes['stream'] = $this;

            return new FormBuilder($attributes);
        });

        Stream::macro('table', function ($table = 'default', $attributes = []) {

            if (is_array($table)) {
                $attributes = $table;
                $table = 'default';
            }

            if (!$configured = Arr::get($this->ui, 'tables.' . $table)) {
                $configured = Arr::get($this->ui, 'table', []);
            }

            $attributes = array_merge($attributes, $configured);

            $attributes['stream'] = $this;

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

            return App::make('streams.input_types.' . ($this->input ?: 'input'), compact('attributes'));
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
