<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Radio extends Input
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
            'template' => 'ui::input/radio',
            'type' => 'radio',
            'classes' => [],
        ], $attributes));
    }
}
