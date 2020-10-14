<?php

namespace Streams\Ui\Table\Workflows\Query;

use Streams\Ui\Table\TableBuilder;

/**
 * Class FinishQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FinishQuery
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $builder->instance->options['total_results'] = $builder->criteria->count();

        /**
         * @todo This terminology and parameters need reviewed/revisited.
         */
        if ($builder->instance->options->get('paginate', true)) {

            $builder->instance->pagination = $builder->criteria->paginate([
                'page_name' => $builder->instance->options->get('prefix') . 'page',
                'limit_name' => $builder->instance->options->get('limit') . 'limit',
                'total_results' => $builder->instance->options->get('total_results'),
            ]);

            $builder->instance->entries = $builder->instance->pagination->getCollection();
        }
    }
}
