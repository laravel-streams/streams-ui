<?php

namespace Anomaly\Streams\Ui\Table;

use Anomaly\Streams\Ui\Table\Table;
use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Table\Workflows\BuildTable;
use Anomaly\Streams\Ui\Table\Workflows\QueryTable;
use Anomaly\Streams\Ui\Table\Component\View\Workflows\BuildViews;

/**
 * Class TableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'async' => false,

        'stream' => null,
        'entries' => null,
        'repository' => null,

        'views' => [],
        'assets' => [],
        'filters' => [],
        'columns' => [],
        'buttons' => [],
        'actions' => [],
        'options' => [],

        'component' => 'table',

        'table' => Table::class,
        
        'workflows' => [
            'build' => BuildTable::class,
            'query' => QueryTable::class,
            'views' => BuildViews::class,
        ],
    ];
}
