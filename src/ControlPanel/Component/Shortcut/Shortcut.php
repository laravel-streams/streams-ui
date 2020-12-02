<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut;

use Streams\Ui\Support\Component;

class Shortcut extends Component
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
            'template' => 'ui::components.cp.shortcut',

            'handle' => null,
            'title' => null,
            'policy' => null,
            'sections' => null,
            'breadcrumb' => null,

            'active' => false,
            'favorite' => false,

            'classes' => [
                'test',
            ],
        ], $attributes));
    }
}
