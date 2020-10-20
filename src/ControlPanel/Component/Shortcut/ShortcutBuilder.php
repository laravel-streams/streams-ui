<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut;

use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Workflows\BuildComponent;
use Streams\Ui\ControlPanel\Component\Shortcut\Shortcut;

/**
 * Class ShortcutBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutBuilder extends Builder
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
            'assets' => [],

            'component' => 'shortcut',

            'shortcut' => Shortcut::class,

            'workflows' => [
                'build' => BuildComponent::class,
            ],
        ], $attributes));
    }
}
