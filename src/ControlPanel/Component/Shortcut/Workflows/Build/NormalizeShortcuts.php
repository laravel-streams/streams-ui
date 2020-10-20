<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build;

use Streams\Ui\Support\Normalizer;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class NormalizeShortcuts
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeShortcuts
{

    /**
     * Handle the step.
     *
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {
        $shortcuts = $builder->shortcuts;

        foreach ($shortcuts as $handle => &$item) {

            // Default the handle.
            if (!isset($item['handle']) && isset($item['id'])) {
                $item['handle'] = $item['id'];
            }

            // Default the handle more.
            if (!isset($item['handle']) && !is_numeric($handle)) {
                $item['handle'] = $handle;
            }

            // Default the stream for now.
            if (!isset($item['stream']) && Streams::has($item['handle'])) {
                $item['stream'] = $item['handle'];
            }
        }

        $shortcuts = Normalizer::attributes($shortcuts);

        $builder->shortcuts = $shortcuts;
    }
}
