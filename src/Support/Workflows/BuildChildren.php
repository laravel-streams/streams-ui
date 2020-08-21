<?php

namespace Anomaly\Streams\Ui\Support\Workflows;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Anomaly\Streams\Ui\Support\Builder;

/**
 * Class BuildChildren
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildChildren
{
    protected function build($builder, $component)
    {
        if ($builder->{$component} === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, $component);

        (new $workflow)->setAttribute('name', 'build_' . $component)->passThrough($builder)->process([
            'builder' => $builder,
            'component' => $component,
        ]);
    }
}
