<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build;

use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class DefaultShortcut
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultShortcut
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
        $builder->navigation = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->toArray();
    }
}
