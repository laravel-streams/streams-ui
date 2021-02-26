<?php

namespace Streams\Ui\Layout;

use Streams\Ui\Support\Component;
use Streams\Ui\Button\ButtonCollection;
use Streams\Ui\Layout\Component\Shortcut\ShortcutCollection;
use Streams\Ui\Layout\Component\Navigation\NavigationCollection;

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
            'layout' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ShortcutCollection::class,
                ],
            ],
        ]);

        return parent::initializePrototype(array_merge([
            'buttons' => [],
            'shortcuts' => [],
            'navigation' => [],
        ], $attributes));
    }
}
