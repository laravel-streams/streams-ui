<?php

namespace Streams\Ui\Table\Action;

use Streams\Ui\Button\Button;
use Illuminate\Support\Facades\App;
use Streams\Ui\Table\Action\ActionHandler;

/**
 * Class Action
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @typescript
 * @property bool $action
 */
class Action extends Button
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
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
