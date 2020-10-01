<?php

namespace Anomaly\Streams\Ui\ControlPanel;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\ControlPanel\Workflows\BuildControlPanel;

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

            'component' => 'control_panel',
            'control_panel' => ControlPanel::class,

            'workflows' => [
                //'rows' => BuildRows::class,
                //'views' => BuildViews::class,
                'build' => BuildControlPanel::class,
                //'query' => QueryTable::class,
                //'actions' => BuildActions::class,
                //'filters' => BuildFilters::class,
                //'columns' => BuildColumns::class,
                //'buttons' => BuildButtons::class,
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
