<?php

namespace Anomaly\Streams\Ui\ControlPanel\Workflows\Build;

use Anomaly\Streams\Ui\ControlPanel\Component\Navigation\NavigationCollection;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class BuildNavigation
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildNavigation extends BuildChildren
{

    /**
     * Handle the step.
     * 
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {
        $this->build($builder, 'navigation');
    }
}
