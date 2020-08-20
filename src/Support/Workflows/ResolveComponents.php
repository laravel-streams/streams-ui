<?php

namespace Anomaly\Streams\Ui\Support\Workflows;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Platform\Support\Facades\Evaluator;
use Anomaly\Streams\Platform\Support\Facades\Resolver;

/**
 * Class ResolveComponents
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ResolveComponents
{

    public function handle(Builder $builder, $component)
    {
        $resolved = Resolver::resolve(
            $builder->{$component},
            ['builder' => $builder]
        );

        $builder->{$component} = Evaluator::evaluate(
            $resolved ?: $builder->{$component},
            ['builder' => $builder]
        );
    }
}
