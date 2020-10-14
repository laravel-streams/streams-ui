<?php

namespace Streams\Ui\Table\Component\Filter\Workflows\Filters;

use Streams\Ui\Table\TableBuilder;

/**
 * Class DefaultFilters
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultFilters
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        // if (!$builder->filters) {
        //     $builder->filters = [
        //         'delete',
        //         'edit',
        //         'export',
        //     ];
        // }
    }
}
