<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class GuessNavigation
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GuessNavigation
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

            /**
             * Guess the title.
             */
            if (!isset($item['title']) && $item['stream']) {
                $item['title'] = $item['stream']->name ?: ucwords(Str::humanize($item['stream']->handle));
            }
        }
        
        $builder->navigation = $navigation;
    }
}
