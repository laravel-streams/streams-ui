<?php

namespace Streams\Ui\ControlPanel\Shortcut;

use Streams\Ui\Button\Button;

/**
 * @property bool $active
 * @property bool $favorite
 * @property \Streams\Ui\ControlPanel\Navigation\Section $sections
 */
class Shortcut extends Button
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeComponentPrototype(array $attributes)
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
