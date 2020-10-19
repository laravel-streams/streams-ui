<?php

namespace Streams\Ui\Table\Component\Filter\Workflows\Filters;

use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\TableBuilder;

/**
 * Class SetActiveFilter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveFilter
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->instance->filters->active()->isNotEmpty()) {
            return;
        }

        $builder->instance->filters->each(function($filter) use ($builder) {
            $filter->active = Request::has($builder->instance->prefix('filter_' . $filter->handle));
        });
    }
}
