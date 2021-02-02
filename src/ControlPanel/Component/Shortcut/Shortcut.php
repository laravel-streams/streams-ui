<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut;

use Streams\Ui\Button\Button;

class Shortcut extends Button
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
            'component' => 'shortcut',

            'tag' => 'button',
            'handle' => null,
            'title' => null,
            'policy' => null,
            'sections' => null,
            'breadcrumb' => null,

            'active' => false,
            'favorite' => false,

            'classes' => [],
        ], $attributes));
    }
}
