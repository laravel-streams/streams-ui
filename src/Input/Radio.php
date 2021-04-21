<?php

namespace Streams\Ui\Input;

class Radio extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'template' => 'ui::input/radio',
            'type' => 'radio',
            'classes' => [],
        ], $attributes));
    }
}
