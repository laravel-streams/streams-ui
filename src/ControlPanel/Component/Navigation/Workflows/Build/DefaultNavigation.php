<?php

namespace Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build;

use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

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
        $builder->navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->toArray();
    }
}
