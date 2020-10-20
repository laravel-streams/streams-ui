<?php

namespace Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Normalizer;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class NormalizeNavigation
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeNavigation
{

    /**
     * Handle the step.
     *
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {
        $navigation = $builder->navigation;

        foreach ($navigation as $handle => &$item) {

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

        $navigation = Normalizer::attributes($navigation);

        $builder->navigation = $navigation;
    }
}
