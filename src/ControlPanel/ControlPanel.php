<?php

namespace Streams\Ui\ControlPanel;

use Streams\Ui\Support\Component;
use Streams\Ui\Button\ButtonCollection;
use Streams\Ui\ControlPanel\Component\Section\SectionCollection;
use Streams\Ui\ControlPanel\Component\Shortcut\ShortcutCollection;
use Streams\Ui\ControlPanel\Component\Navigation\NavigationCollection;

/**
 * Class ControlPanel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControlPanel extends Component
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

        return parent::initializePrototype(array_merge([
            'buttons' => ButtonCollection::class,
            'sections' => SectionCollection::class,
            'shortcuts' => ShortcutCollection::class,
            'navigation' => NavigationCollection::class,
        ], $attributes));
    }
}
