<?php

namespace Streams\Ui\Form\Component\Action;

use Streams\Ui\Button\Button;

/**
 * Class Action
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Action extends Button
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'tag' => 'button',
            'as' => 'button',
            'url' => null,
            'text' => null,
            'entry' => null,
            'policy' => null,
            'enabled' => true,
            'primary' => false,
            'disabled' => false,
            'type' => 'default',

            // Extended
            'prefix' => null,
            'redirect' => null,

            'save' => true,
            'active' => false,

            'classes' => [
                'py-2',
                'px-4',
                'rounded',
                'border-2',
                'font-bold',
                'text-black',
                'border-black',
                'inline-block'
            ],

            'handle' => 'default',
            'handler' => ActionHandler::class,
        ], $attributes));
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge(parent::attributes(), [
            'value' => $this->handle,
            'type'  => $this->type,
            'name'  => 'action',
        ], $attributes);
    }
}
