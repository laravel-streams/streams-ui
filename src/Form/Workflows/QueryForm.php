<?php

namespace Streams\Ui\Form\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\StartQuery;
use Streams\Ui\Form\Workflows\Query\FinishQuery;

/**
 * Class QueryWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class QueryForm extends Workflow
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
        FinishQuery::class,
    ];
}
