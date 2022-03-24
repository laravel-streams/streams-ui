<?php

namespace Streams\Ui\Input;

class Color extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    public function initializeComponentPrototype(array $attributes)
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::input/color',
            'type' => 'color',
        ], $attributes));
    }
}
