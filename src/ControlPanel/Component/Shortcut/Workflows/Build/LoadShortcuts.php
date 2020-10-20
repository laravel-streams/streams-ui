<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build;

use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class LoadShortcuts
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadShortcuts
{

    /**
     * Handle the step.
     *
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {
        if ($builder->shortcuts) {
            return;
        }

        /**
         * If no shortcuts is set
         * then make a shortcuts
         * item for each stream.
         */
        $builder->shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->toArray();
    }
}
