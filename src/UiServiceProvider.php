<?php

namespace Anomaly\Streams\Ui;

use Illuminate\Support\ServiceProvider;

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
        //'UI' => \Anomaly\Streams\Platform\Support\Facades\Streams::class
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
        //'locator' => \Anomaly\Streams\Platform\Support\Locator::class,


        \Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class                     => \Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class,
        \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class                 => \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class,
        \Anomaly\Streams\Platform\Support\Breadcrumb::class       => \Anomaly\Streams\Platform\Support\Breadcrumb::class,
        \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder::class      => \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder::class,
        \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::class     => \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::class,
        \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry::class => \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry::class,

    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerInputTypes();
        
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        /**
         * Register publishables.
         */
        $this->publishes([
            base_path('vendor/anomaly/streams-ui/docs') => base_path(
                implode(DIRECTORY_SEPARATOR, ['docs', 'ui'])
            )
        ], ['docs']);
    }

    /**
     * Register the field types.
     */
    protected function registerInputTypes()
    {
        $this->app->bind('text', \Anomaly\Streams\Platform\Field\Type\Text::class);
        $this->app->bind('bool', \Anomaly\Streams\Platform\Field\Type\Boolean::class);
        $this->app->bind('boolean', \Anomaly\Streams\Platform\Field\Type\Boolean::class);
        $this->app->bind('textarea', \Anomaly\Streams\Platform\Field\Type\Textarea::class);
    }
}
