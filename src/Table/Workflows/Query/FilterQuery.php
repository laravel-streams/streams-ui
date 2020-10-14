<?php

namespace Streams\Ui\Table\Workflows\Query;

use Illuminate\Support\Facades\App;
use Streams\Ui\Table\TableBuilder;

/**
 * Class FilterQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FilterQuery
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        foreach ($builder->instance->filters->active() as $filter) {

            /*
            * If the handler is a callable string or Closure
            * then call it using the IoC container.
            */
            $query = $filter->query ?: [$filter, 'query'];

            App::call($filter->query, compact('builder', 'filter'), 'handle');
        }
    }
}
