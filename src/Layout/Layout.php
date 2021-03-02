<?php

namespace Streams\Ui\Layout;

use Streams\Ui\Support\Component;
use Streams\Ui\Layout\Component\Shortcut\ShortcutCollection;

class Layout extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
            'content' => [
                'type' => 'collection',
            ],
        ]);

        return parent::initializePrototype(array_merge([
            // 'buttons' => [],
            // 'shortcuts' => [],
            'content' => [],
            'component' => 'layout',
            'template'  => 'ui::layouts.layout',
        ], $attributes));
    }
}
