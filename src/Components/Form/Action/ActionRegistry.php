<?php namespace Streams\Ui\Components\Form\Action;

use Illuminate\Support\Arr;
use Streams\Ui\Button\ButtonRegistry;
use Streams\Ui\Components\Form\Action\Handler\Save;

class ActionRegistry
{

    /**
     * Available actions.
     *
     * @var array
     */
    protected $actions = [
        'save'         => [
            'button' => 'save',
            'text'   => 'ui::buttons.save',
            'handler' => Save::class,
        ],
        'update'         => [
            'button' => 'update',
            'text'   => 'ui::buttons.update',
            'handler' => Save::class,
        ],
        'save_exit'      => [
            'button' => 'save',
            'text'   => 'ui::buttons.save_exit',
            'handler' => Save::class,
        ],
        'save_edit'      => [
            'button' => 'save',
            'text'   => 'ui::buttons.save_edit',
            'handler' => Save::class,
        ],
        'save_create'    => [
            'button' => 'save',
            'text'   => 'ui::buttons.save_create',
            'handler' => Save::class,
        ],
        'save_continue'  => [
            'button' => 'save',
            'text'   => 'ui::buttons.save_continue',
            'handler' => Save::class,
        ],
        'save_edit_next' => [
            'button' => 'save',
            'text'   => 'ui::buttons.save_edit_next',
            'handler' => Save::class,
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
