<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build;

use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class DefaultNavigation
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultNavigation
{

    /**
     * Handle the step.
     *
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {
        if ($builder->navigation) {
            return;
        }

        /**
         * If no navigation is set
         * then make a navigation
         * item for each stream.
         */
        $builder->navigation = Streams::collection()->keys()->all();
    }
}
