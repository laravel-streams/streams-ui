<?php

namespace Anomaly\Streams\Ui\Table;

use Anomaly\Streams\Ui\Table\Table;
use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Table\Workflows\BuildTable;
use Anomaly\Streams\Ui\Table\Workflows\QueryTable;
use Anomaly\Streams\Ui\Table\Component\Row\Workflows\BuildRows;
use Anomaly\Streams\Ui\Table\Component\View\Workflows\BuildViews;
use Anomaly\Streams\Ui\Table\Component\Action\Workflows\BuildActions;
use Anomaly\Streams\Ui\Table\Component\Button\Workflows\BuildButtons;
use Anomaly\Streams\Ui\Table\Component\Column\Workflows\BuildColumns;
use Anomaly\Streams\Ui\Table\Component\Filter\Workflows\BuildFilters;

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
            'actions' => BuildActions::class,
            'filters' => BuildFilters::class,
            'columns' => BuildColumns::class,
            'buttons' => BuildButtons::class,
            'rows' => BuildRows::class,
        ],
    ];
}
