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
    protected function initializePrototypeTrait(array $attributes)
    {
        return parent::initializePrototypeTrait(array_merge([
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
