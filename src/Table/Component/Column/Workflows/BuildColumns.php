<?php

namespace Anomaly\Streams\Ui\Table\Component\Column\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Table\Component\Column\Workflows\Columns\ExpandColumns;
use Anomaly\Streams\Ui\Table\Component\Column\Workflows\Columns\DefaultColumns;
use Anomaly\Streams\Ui\Table\Component\Column\Workflows\Columns\NormalizeColumns;

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

        //'merge_columns' => MergeComponents::class,

        //'translate_columns' => TranslateComponents::class,
        //'parse_columns' => ParseComponents::class,

        'build_columns' => BuildComponents::class,
    ];
}
