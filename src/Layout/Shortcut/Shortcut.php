<?php

namespace Streams\Ui\ControlPanel\Shortcut;

use Streams\Ui\Button\Button;

class Shortcut extends Button
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'component' => 'shortcut',

            'tag' => 'a',
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
