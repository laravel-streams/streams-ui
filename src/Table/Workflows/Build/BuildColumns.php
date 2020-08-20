<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Table\Component\Column\Workflows\ColumnsWorkflow;

/**
 * Class BuildColumns
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildColumns
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

        (new ColumnsWorkflow)->process([
            'builder' => $builder,
            'component' => 'columns',
        ]);
    }
}
