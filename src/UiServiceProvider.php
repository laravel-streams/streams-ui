<?php

namespace Anomaly\Streams\Ui;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Input\Input;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Ui\Input\Color;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Anomaly\Streams\Ui\Input\Textarea;
use Anomaly\Streams\Ui\Input\Markdown;
use Illuminate\Support\ServiceProvider;
use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Field\Field;
use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Facades\Assets;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Ui\Input\Datetime;

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
        //'UI' => \Anomaly\Streams\Ui\Support\Facades\UI::class
    ];

    /**
     * The class bindings.
     *
     * @var array
     */
    public $bindings = [
        //\Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface::class  => \Anomaly\Streams\Platform\Stream\StreamRepository::class,
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [
        \Anomaly\Streams\Ui\Icon\IconRegistry::class                     => \Anomaly\Streams\Ui\Icon\IconRegistry::class,
        \Anomaly\Streams\Ui\Support\Breadcrumb::class                     => \Anomaly\Streams\Ui\Support\Breadcrumb::class,
        \Anomaly\Streams\Ui\Button\ButtonRegistry::class                 => \Anomaly\Streams\Ui\Button\ButtonRegistry::class,
        \Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder::class      => \Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder::class,
        \Anomaly\Streams\Ui\Table\Component\View\ViewRegistry::class     => \Anomaly\Streams\Ui\Table\Component\View\ViewRegistry::class,
        \Anomaly\Streams\Ui\Table\Component\Filter\FilterRegistry::class => \Anomaly\Streams\Ui\Table\Component\Filter\FilterRegistry::class,

    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('streams.input_types.text', Input::class);
        $this->app->bind('streams.input_types.input', Input::class);
        $this->app->bind('streams.input_types.string', Input::class);

        $this->app->bind('streams.input_types.color', Color::class);
        $this->app->bind('streams.input_types.datetime', Datetime::class);
        $this->app->bind('streams.input_types.textarea', Textarea::class);
        $this->app->bind('streams.input_types.markdown', Markdown::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            base_path('vendor/anomaly/streams-ui/resources/public')
            => public_path('vendor/anomaly/streams/ui')
        ], ['public']);

        Streams::register([
            'handle' => 'cp.navigation',
            'source' => [
                'path' => 'streams/cp/navigation',
                'format' => 'json',
            ],
            'fields' => [
                'title' => 'string',
            ],
        ]);

        $this->extendLang();
        $this->extendView();
        $this->extendAssets();

        $this->extendStream();
        $this->extendField();
    }

    /**
     * Extend stream objects.
     */
    protected function extendStream()
    {
        Stream::macro('form', function ($attributes = []) {

            $default = Arr::get($this->ui, 'form', []);

            $attributes = array_merge($attributes, $default);

            $attributes['stream'] = $this;

            return new FormBuilder($attributes);
        });

        Stream::macro('table', function ($attributes = []) {

            $default = Arr::get($this->ui, 'table', []);

            $attributes = array_merge($attributes, $default);

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
        Lang::addNamespace('ui', base_path('vendor/anomaly/streams-ui/resources/lang'));
    }

    /**
     * Extend view support.
     */
    protected function extendView()
    {
        View::composer('ui::default', function ($view) {
            $view->with('cp', (new ControlPanelBuilder())->build()->instance);
        });

        View::addNamespace('ui', base_path('vendor/anomaly/streams-ui/resources/views'));
    }

    /**
     * Extend asset support.
     */
    protected function extendASsets()
    {
        Assets::addPath('ui', base_path('vendor/anomaly/streams-ui/resources'));
    }
}
