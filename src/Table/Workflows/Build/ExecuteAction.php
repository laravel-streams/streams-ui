<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Table\Component\Action\ActionExecutor;

/**
 * Class ExecuteAction
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExecuteAction
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     * @param ActionExecutor $executor
     */
    public function handle(TableBuilder $builder, ActionExecutor $executor)
    {
        if (!request()->isMethod('post')) {
            return;
        }

        dd('ExecuteAction not implemented yet.');

        $actions = $builder->instance->getActions();

        if ($action = $actions->active()) {
            $executor->execute($builder, $action);
        }
    }
}
