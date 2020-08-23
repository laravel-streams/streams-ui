<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Query;

use Anomaly\Streams\Ui\Table\TableBuilder;

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
        $builder->table->options['total_results'] = $builder->criteria->count();

        /**
         * @todo This terminology and parameters need reviewed/revisited.
         */
        if ($builder->table->options->get('paginate', true)) {

            $builder->table->pagination = $builder->criteria->paginate([
                'page_name' => $builder->table->options->get('prefix') . 'page',
                'limit_name' => $builder->table->options->get('limit') . 'limit',
                'total_results' => $builder->table->options->get('total_results'),
            ]);

            $builder->table->entries = $builder->table->pagination->getCollection();
        }
    }
}
