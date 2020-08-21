<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class BuildRows
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildRows
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->table->entries) {
            return;
        }

        if ($builder->table->entries->isEmpty()) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'rows');

        (new $workflow)->setAttribute('name', 'build_rows')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'rows',
        ]);
    }
}
