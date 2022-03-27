<?php

namespace Streams\Ui\Components\Table\Action;

use Streams\Ui\Components\Button;
use Illuminate\Support\Facades\App;


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
        if (!$this->handler) {
            return;
        }

        App::call($this->handler, $payload);
    }
}
