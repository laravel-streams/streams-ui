<?php

namespace Streams\Ui\ControlPanel;

use Streams\Ui\Support\Component;
use Streams\Ui\Button\ButtonCollection;
use Streams\Ui\ControlPanel\Component\Shortcut\ShortcutCollection;
use Streams\Ui\ControlPanel\Component\Navigation\NavigationCollection;

class ControlPanel extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        $this->loadPrototypeProperties([
            'buttons' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ButtonCollection::class,
                ],
            ],
            'navigation' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => NavigationCollection::class,
                ],
            ],
            'shortcuts' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ShortcutCollection::class,
                ],
            ],
        ]);

        return parent::initializePrototypeAttributes(array_merge([
            'buttons' => [],
            'shortcuts' => [],
            'navigation' => [],
        ], $attributes));
    }
}
