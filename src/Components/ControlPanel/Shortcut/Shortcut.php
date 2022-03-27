<?php

namespace Streams\Ui\Components\ControlPanel\Shortcut;

use Streams\Ui\Components\Button;

class Shortcut extends Button
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'shortcut',

            'tag' => 'button',
            'handle' => null,
            'title' => null,
            'policy' => null,
            'sections' => null,
            'breadcrumb' => null,

            'active' => false,
            'favorite' => false,
        ], $attributes));
    }
}
