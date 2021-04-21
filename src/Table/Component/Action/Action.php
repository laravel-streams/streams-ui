<?php

namespace Streams\Ui\Table\Component\Action;

use Streams\Ui\Button\Button;
use Illuminate\Support\Facades\App;
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
    protected function initializePrototypeInstance(array $attributes)
    {
        return parent::initializePrototypeInstance(array_merge([
            'component' => 'button',
            'tag' => 'button',
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
            //'handler' => ActionHandler::class,
        ], $attributes));
    }

    public function handle(array $payload = [])
    {
        $payload['action'] = $this;

        return App::call($this->handler, $payload, 'handle');
    }
}
