<?php

namespace Streams\Ui\Support\Workflows;

use Streams\Ui\Support\Builder;
use Streams\Core\Support\Facades\Resolver;
use Streams\Core\Support\Facades\Evaluator;

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
