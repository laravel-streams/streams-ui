<?php

namespace Anomaly\Streams\Ui\Table;

use Illuminate\Support\Collection;
use Anomaly\Streams\Ui\Support\Component;
use Anomaly\Streams\Ui\Table\Component\View\ViewCollection;
use Anomaly\Streams\Ui\Table\Component\Action\ActionCollection;
use Anomaly\Streams\Ui\Table\Component\Filter\FilterCollection;

/**
 * Class Table
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Table extends Component
{

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge([
            'component' => 'table',

            'rows' => new Collection(),
            'buttons' => new Collection(),
            'columns' => new Collection(),
            'entries' => new Collection(),
            'options' => new Collection(),

            'views' => new ViewCollection(),
            'actions' => new ActionCollection(),
            'filters' => new FilterCollection(),
        ], $attributes));
    }

    protected $properties = [
        'views' => [
            'type' => 'collection',
            'config' => [
                'abstract' => ViewCollection::class,
            ],
        ],
        'actions' => [
            'type' => 'collection',
            'config' => [
                'abstract' => ActionCollection::class,
            ],
        ],
        'filters' => [
            'type' => 'collection',
            'config' => [
                'abstract' => FilterCollection::class,
            ],
        ],

        'rows' => [
            'type' => 'collection',
        ],
        'buttons' => [
            'type' => 'collection',
        ],
        'columns' => [
            'type' => 'collection',
        ],
        'entries' => [
            'type' => 'collection',
        ],
        'options' => [
            'type' => 'collection',
        ],
    ];
}
