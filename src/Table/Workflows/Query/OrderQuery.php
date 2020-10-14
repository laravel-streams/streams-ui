<?php

namespace Streams\Ui\Table\Workflows\Query;

use Streams\Ui\Table\TableBuilder;

/**
 * Class OrderQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class OrderQuery
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($name = $builder->request('order_by')) {
            $builder->criteria->orderBy($name, $builder->request('sort', 'asc'));
        }

        if (!$name && $builder->instance->options->has('order_by')) {
            foreach ($builder->instance->options->get('order_by') as $name => $sort) {
                $builder->criteria->orderBy($name, $sort);
            }
        }
    }
}
