<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Table\Component\View\Workflows\ViewsWorkflow;

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

        (new ViewsWorkflow)->process([
            'builder' => $builder,
            'component' => 'views',
        ]);
    }
}
