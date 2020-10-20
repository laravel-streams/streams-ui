<?php

namespace Streams\Ui\ControlPanel\Workflows\Build;

use Streams\Ui\Support\Workflows\BuildChildren;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class BuildShortcuts
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildShortcuts extends BuildChildren
{

    /**
     * Handle the step.
     * 
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {
        $this->build($builder, 'shortcuts');
    }
}
