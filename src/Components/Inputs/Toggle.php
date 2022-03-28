<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Toggle extends Input
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::components.inputs.toggle',
            'type' => 'checkbox',
            'classes' => [
                'c-input',
                '-toggle-input',
            ],
        ], $attributes));
    }
}
