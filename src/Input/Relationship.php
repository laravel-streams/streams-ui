<?php

namespace Streams\Ui\Input;

use Streams\Ui\Support\Component;

class Select extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'template' => 'ui::input/relationship',
        ], $attributes));
    }
}
