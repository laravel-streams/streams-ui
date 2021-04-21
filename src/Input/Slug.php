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
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'template' => 'ui::input/slug',
        ], $attributes));
    }
}
