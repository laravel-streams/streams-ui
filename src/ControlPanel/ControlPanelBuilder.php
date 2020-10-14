<?php

namespace Streams\Ui\ControlPanel;

use Streams\Ui\Support\Builder;
use Streams\Ui\ControlPanel\Workflows\BuildControlPanel;
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
            ],
        ], $attributes));
    }

    // NavigationBuilder::build($this);
    // dispatch_now(new SetActiveNavigationLink($this));
    // dispatch_now(new SetMainNavigationLinks($this));
    // SectionBuilder::build($this);
    // dispatch_now(new SetActiveSection($this));
    // ShortcutBuilder::build($this);
    // ButtonBuilder::build($this);
}
