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
    protected function initializePrototypeInstance(array $attributes)
    {
        return parent::initializePrototypeInstance(array_merge([
            'template' => 'ui::input/radio',
            'type' => 'radio',
            'classes' => [],
        ], $attributes));
    }
}
