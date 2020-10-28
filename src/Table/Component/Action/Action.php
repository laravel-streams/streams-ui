<?php

namespace Streams\Ui\Table\Component\Action;

use Streams\Ui\Button\Button;
use Streams\Ui\Table\Component\Action\ActionHandler;

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
            'component' => 'action',
            //'template' => 'ui::buttons.button',

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
            'name' => 'action',
    
            // Extended
            'prefix' => null,
            'redirect' => null,
    
            'save' => true,
            'active' => false,
    
            'handle' => 'default',
            'handler' => ActionHandler::class,
        ], $attributes));
    }
}
