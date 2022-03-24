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
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::input/checkbox',
            'type' => 'checkbox',
        ], $attributes));
    }
}
