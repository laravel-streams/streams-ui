<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class BuildActions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildActions extends BuildChildren
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $this->build($builder, 'actions');
    }
}
