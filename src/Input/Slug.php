<?php

namespace Streams\Ui\Input;

class Slug extends Input
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
            'template' => 'ui::input/slug',
        ], $attributes));
    }
}
