<?php

namespace Streams\Ui\Input;

use Streams\Ui\Input\Input;

class Toggle extends Input
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
            'template' => 'ui::input/toggle',
            'type' => 'checkbox',
        ], $attributes));
    }
}
