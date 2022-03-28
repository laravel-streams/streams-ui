<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Color extends Input
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::components.inputs.color',
            'type' => 'color',
        ], $attributes));
    }
}
