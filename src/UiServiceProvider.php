<?php

namespace Anomaly\Streams\Platform;

use Exception;
use Parsedown;
use Misd\Linkify\Linkify;
use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Translation\Translator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Purifier;
use Anomaly\Streams\Platform\View\ViewIncludes;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Anomaly\Streams\Platform\Asset\Facades\Assets;
use Anomaly\Streams\Platform\Image\Facades\Images;
use Anomaly\Streams\Platform\Stream\StreamBuilder;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Ui\Table\TableComponent;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Illuminate\Support\Collection as SupportCollection;
use Anomaly\Streams\Platform\Http\Controller\EntryController;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * Class StreamsServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamsServiceProvider extends ServiceProvider
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
