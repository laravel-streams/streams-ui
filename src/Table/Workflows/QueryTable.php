<?php

namespace Streams\Ui\Table\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\StartQuery;
use Streams\Ui\Table\Workflows\Query\OrderQuery;
use Streams\Ui\Table\Workflows\Query\FilterQuery;
use Streams\Ui\Table\Workflows\Query\FinishQuery;

/**
 * Class QueryTable
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class QueryTable extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [

        /**
         * Query dem results.
         */
        StartQuery::class,
        FilterQuery::class,
        OrderQuery::class,
        FinishQuery::class,
    ];
}
