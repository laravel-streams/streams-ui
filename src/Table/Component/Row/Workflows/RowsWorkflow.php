<?php

namespace Anomaly\Streams\Ui\Table\Component\Row\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Table\Component\Row\Workflows\Rows\DefaultRows;
use Anomaly\Streams\Ui\Table\Component\Row\Workflows\Rows\ValuateRows;

/**
 * Class RowsWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RowsWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_rows' => ResolveComponents::class,

        DefaultRows::class,

        'build_rows' => BuildComponents::class,

        ValuateRows::class,
    ];
}
