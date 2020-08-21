<?php

namespace Anomaly\Streams\Ui\Table\Component\Row;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponent;

/**
 * Class RowBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RowBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'entry' => null,
        'parent' => null,

        'assets' => [],

        'component' => 'row',

        'row' => Row::class,

        'workflows' => [
            'build' => BuildComponent::class,
        ],
    ];
}
