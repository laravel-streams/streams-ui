<?php

namespace Streams\Ui\Support\Workflows;

use Illuminate\Support\Arr;

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

        (new $workflow)->setPrototypeAttribute('name', 'build_' . $component)->passThrough($builder)->process([
            'builder' => $builder,
            'component' => $component,
        ]);
    }
}
