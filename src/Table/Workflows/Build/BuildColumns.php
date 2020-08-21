<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class BuildColumns
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildColumns
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->actions === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'columns');

        (new $workflow)->setAttribute('name', 'build_columns')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'columns',
        ]);
    }
}
