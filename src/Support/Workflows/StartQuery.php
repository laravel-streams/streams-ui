<?php

namespace Streams\Ui\Support\Workflows;

use Streams\Ui\Support\Builder;

/**
 * Class StartQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StartQuery
{

    /**
     * Handle the step.
     * 
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        $builder->criteria = $builder->repository()->newCriteria();
    }
}
