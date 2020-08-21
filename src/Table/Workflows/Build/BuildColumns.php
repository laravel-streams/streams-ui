<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class BuildColumns
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildColumns extends BuildChildren
{
    public function handle(TableBuilder $builder)
    {
        $this->build($builder, 'columns');
    }
}
