<?php

namespace Streams\Ui\ControlPanel;

use Streams\Ui\Support\Builder;
use Streams\Ui\ControlPanel\Workflows\BuildControlPanel;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\BuildShortcuts;
use Streams\Ui\ControlPanel\Component\Navigation\Workflows\BuildNavigation;

/**
 * Class ControlPanelBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControlPanelBuilder extends Builder
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

            'options' => [],
            
            'navigation' => [],

            'component' => 'control_panel',
            'control_panel' => ControlPanel::class,

            'workflows' => [
                'build' => BuildControlPanel::class,
                'navigation' => BuildNavigation::class,
                'shortcuts' => BuildShortcuts::class,
            ],
        ], $attributes));
    }
}
