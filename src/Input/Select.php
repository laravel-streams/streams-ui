<?php

namespace Streams\Ui\Input;

class Select extends Input
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
            'template' => 'ui::input/select',
            'type' => null,
        ], $attributes));
    }
}
