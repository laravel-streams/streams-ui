<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class BuildViews
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildViews
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->views === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'views');

        (new $workflow)->setAttribute('name', 'build_views')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'views',
        ]);
    }
}
