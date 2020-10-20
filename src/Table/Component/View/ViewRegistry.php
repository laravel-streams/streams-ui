<?php

namespace Streams\Ui\Table\Component\View;

use Illuminate\Support\Arr;
use Streams\Ui\Table\Component\View\Type\Trash;
use Streams\Ui\Table\Component\View\Type\RecentlyCreated;
use Streams\Ui\Table\Component\View\Type\RecentlyModified;

/**
 * Class ViewRegistry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ViewRegistry
{

    /**
     * Available views.
     *
     * @var array
     */
    protected $views = [
        'all'               => [
            'handle' => 'all',
            'text' => 'ui::buttons.all',
        ],
        'trash'             => [
            'handle'    => 'trash',
            'text'    => 'ui::buttons.trash',
            'view'    => Trash::class,
            'buttons' => [
                'restore' => [],
            ],
            'actions' => [
                'force_delete' => [],
            ],
            'options' => [
                'sortable' => false,
            ],
        ],
        'recently_created'  => [
            'handle' => 'recently_created',
            'text' => 'ui::view.recently_created',
            'view' => RecentlyCreated::class,
        ],
        'recently_modified' => [
            'handle' => 'recently_modified',
            'text' => 'ui::view.recently_modified',
            'view' => RecentlyModified::class,
        ],
    ];

    /**
     * Get a view.
     *
     * @param  $view
     * @return null|array
     */
    public function get($view)
    {
        if (!$view) {
            return null;
        }

        return Arr::get($this->views, $view);
    }

    /**
     * Register a view.
     *
     * @param        $view
     * @param  array $parameters
     * @return $this
     */
    public function register($view, array $parameters)
    {
        Arr::set($this->views, $view, $parameters);

        return $this;
    }
}
