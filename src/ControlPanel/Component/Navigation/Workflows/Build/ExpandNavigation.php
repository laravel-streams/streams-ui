<?php

namespace Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ExpandNavigation
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExpandNavigation
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

            // Load the stream.
            if (isset($item['stream']) && !$item['stream'] instanceof Stream) {
                $item['stream'] = Streams::make($item['stream']);
            }

            // Guess the title from the stream.
            if (!isset($item['title'])) {
                $this->guessTitle($item, $handle);
            }
        }

        $builder->navigation = $navigation;
    }

    public function guessTitle($item, $handle)
    {
        if (isset($item['stream'])) {

            $item['title'] = $item['stream']->name ?: Str::title($item['stream']->handle);

            return;
        }

        $item['title'] = Str::title($handle);
    }
}
