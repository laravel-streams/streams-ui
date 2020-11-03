<?php

namespace Streams\Ui\Table\Component\Row\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Table\Component\Row\Workflows\Rows\DefaultRows;
use Streams\Ui\Table\Component\Row\Workflows\Rows\ValuateRows;

/**
 * Class BuildRows
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildRows extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        //'resolve_rows' => ResolveComponents::class,

        DefaultRows::class,

        'build_rows' => BuildComponents::class,

        // Load Columns
        // Load Buttons

        ValuateRows::class,
    ];
}
