<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Table\Component\Action\Workflows\ActionsWorkflow;

/**
 * Class BuildActions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildActions
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

        $workflow = Arr::get($builder->workflows, 'actions');

        (new $workflow)->setAttribute('name', 'build_actions')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'actions',
        ]);
    }
}
