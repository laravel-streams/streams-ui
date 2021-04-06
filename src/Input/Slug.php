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
    protected function initializePrototypeTrait(array $attributes)
    {
        return parent::initializePrototypeTrait(array_merge([
            'template' => 'ui::input/slug',
        ], $attributes));
    }
}
