<?php

namespace Streams\Ui\Input;

use Streams\Ui\Input\Input;

class Checkbox extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeElementPrototype(array $attributes)
    {
        return parent::initializeElementPrototype(array_merge([
            'template' => 'ui::input/checkbox',
            'type' => 'checkbox',
        ], $attributes));
    }
}
