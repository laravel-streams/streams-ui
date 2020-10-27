<?php

namespace Streams\Ui\Table\Component\Column\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Table\Component\Column\Workflows\Columns\ExpandColumns;
use Streams\Ui\Table\Component\Column\Workflows\Columns\DefaultColumns;
use Streams\Ui\Table\Component\Column\Workflows\Columns\NormalizeColumns;

/**
 * Class BuildColumns
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildColumns extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_columns' => ResolveComponents::class,

        DefaultColumns::class,
        NormalizeColumns::class,
        ExpandColumns::class,

        'build_columns' => BuildComponents::class,
    ];
}
