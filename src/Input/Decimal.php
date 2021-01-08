<?php

namespace Streams\Ui\Input;

class Decimal extends Number
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
            'template' => 'ui::input/decimal',
            'type' => 'number',
            'config' => [
                'step' => 0.1,
            ],
        ], $attributes));
    }
}
