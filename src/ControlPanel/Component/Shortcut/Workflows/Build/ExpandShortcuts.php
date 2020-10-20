<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ExpandShortcuts
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExpandShortcuts
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

            // Load the stream.
            if (isset($item['stream']) && !$item['stream'] instanceof Stream) {
                $item['stream'] = Streams::make($item['stream']);
            }

            // Guess the title from the stream.
            if (!isset($item['title'])) {
                $this->guessTitle($item, $handle);
            }
        }
        
        $builder->shortcuts = $shortcuts;
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
