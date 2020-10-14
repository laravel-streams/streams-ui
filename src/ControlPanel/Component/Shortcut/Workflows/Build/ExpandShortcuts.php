<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build;

use Illuminate\Support\Str;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ExpandShortcut
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExpandShortcut
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

            if (!$item['stream']) {
                continue;
            }

            if (!isset($item['title']) && $item['stream']) {
                $item['title'] = $item['stream']->name ?: ucwords(Str::humanize($item['stream']->handle));
            }
        }
        
        $builder->navigation = $navigation;
    }
}
