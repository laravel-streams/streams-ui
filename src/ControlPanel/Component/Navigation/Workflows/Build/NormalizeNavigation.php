<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Anomaly\Streams\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

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

            /*
             * If the link is a string
             * then it must be in the
             * $path => $title format.
             */
            if (is_string($item)) {
                $item = [
                    'stream' => $item,
                ];
            }

            /*
             * Set/move the stream.
             */
            $item['stream'] = Arr::get($item, 'stream', $handle);

            if ($item['stream'] && !$item['stream'] instanceof Stream) {
                $item['stream'] = Streams::make($item['stream']);
            }

            /*
             * Make sure we have attributes.
             */
            $item['attributes'] = Arr::get($item, 'attributes', []);

            /*
             * Move the HREF into attributes.
             */
            if (isset($item['href'])) {
                $item['attributes']['href'] = Arr::pull($item, 'href');
            }

            /*
             * Move all data-* keys
             * to attributes.
             */
            foreach ($item as $attribute => $value) {
                if (Str::is('data-*', $attribute)) {
                    Arr::set($item, 'attributes.' . $attribute, Arr::pull($item, $attribute));
                }
            }

            /*
             * Make sure the HREF is absolute.
             */
            if (
                isset($item['attributes']['href']) &&
                is_string($item['attributes']['href']) &&
                !Str::startsWith($item['attributes']['href'], 'http')
            ) {
                $item['attributes']['href'] = url($item['attributes']['href']);
            }
        }

        $navigation = Normalizer::attributes($navigation);

        $builder->navigation = $navigation;
        dd($builder->navigation);
    }
}
