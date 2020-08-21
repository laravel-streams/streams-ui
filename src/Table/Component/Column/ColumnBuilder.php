<?php

namespace Anomaly\Streams\Ui\Table\Component\Column;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Support\Workflows\BuildWorkflow;

/**
 * Class ColumnBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ColumnBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'column',

        'column' => Column::class,

        'workflows' => [
            'build' => BuildWorkflow::class,
        ],
    ];
}
