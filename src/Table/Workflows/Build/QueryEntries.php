<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class QueryEntries
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class QueryEntries
{

    /**
     * Handle the command.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->entries === false) {
            return;
        }

        if (!$builder->repository) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'query');

        (new $workflow)->setAttribute('name', 'query_table')->passThrough($builder)->process([
            'builder' => $builder,
        ]);
    }
}
