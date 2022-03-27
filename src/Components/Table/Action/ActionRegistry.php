<?php namespace Streams\Ui\Components\Table\Action;

use Illuminate\Support\Arr;
use Streams\Ui\Button\ButtonRegistry;
use Streams\Ui\Components\Table\Action\Handler\Edit;
use Streams\Ui\Components\Table\Action\Handler\Delete;
use Streams\Ui\Components\Table\Action\Handler\Export;
use Streams\Ui\Components\Table\Action\Handler\Reorder;
use Streams\Ui\Components\Table\Action\Handler\ForceDelete;

/**
 * Class ActionRegistry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ActionRegistry
{

    /**
     * Available actions.
     *
     * @var array
     */
    protected $actions = [
        'delete'       => [
            'handler' => Delete::class,
        ],
        'prompt'       => [
            'handler' => Delete::class,
        ],
        'force_delete' => [
            'button'  => 'prompt',
            'handler' => ForceDelete::class,
            'text'    => 'ui::buttons.force_delete',
        ],
        'export'       => [
            'button'  => 'info',
            'icon'    => 'download',
            'handler' => Export::class,
            'text'    => 'ui::buttons.export',
        ],
        'edit'         => [
            'handler' => Edit::class,
        ],
        'reorder'      => [
            'handler'    => Reorder::class,
            'text'       => 'ui::buttons.reorder',
            'icon'       => 'fa fa-sort-amount-asc',
            'class'      => 'reorder',
            'type'       => 'success',
            'attributes' => [
                'data-ignore',
            ],
        ],
    ];

    /**
     * Get a action.
     *
     * @param  $action
     * @return array|null
     */
    public function get($action)
    {
        if (!$action) {
            return null;
        }

        $registered = Arr::get($this->actions, $action);

        if ($button = app(ButtonRegistry::class)->get(Arr::get($registered, 'button'))) {
            $registered = array_replace_recursive($button, Arr::except($registered, ['button']));
        }

        return $registered;
    }

    /**
     * Register a action.
     *
     * @param        $action
     * @param  array $parameters
     * @return $this
     */
    public function register($action, array $parameters)
    {
        Arr::set($this->actions, $action, $parameters);

        return $this;
    }
}
