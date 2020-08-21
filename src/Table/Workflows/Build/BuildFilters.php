<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class BuildFilters
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFilters
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->filters === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'filters');

        (new $workflow)->setAttribute('name', 'build_filters')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'filters',
        ]);
    }
}
