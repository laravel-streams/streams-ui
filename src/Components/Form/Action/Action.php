<?php

namespace Streams\Ui\Components\Form\Action;

use Streams\Ui\Components\Button;

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
            'tag'      => 'button',
            'url'      => null,
            'text'     => null,
            'entry'    => null,
            'policy'   => null,
            'enabled'  => true,
            'primary'  => false,
            'disabled' => false,
            'type'     => 'default',

            // Extended
            'prefix'   => null,
            'redirect' => null,

            'save'   => true,
            'active' => false,

            'handle'  => 'default',
        ], $attributes));
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = []): array
    {
        return array_merge(parent::attributes(), [
            'value' => $this->handle,
            'type'  => $this->type,
            'name'  => 'action',
        ], $attributes);
    }
}