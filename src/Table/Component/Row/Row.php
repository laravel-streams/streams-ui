<?php

namespace Anomaly\Streams\Ui\Table\Component\Row;

use Anomaly\Streams\Ui\Support\Component;
use Anomaly\Streams\Ui\Button\ButtonCollection;

/**
 * Class Row
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Row extends Component
{

    /**
     * The object attributes.
     *
     * @var array
     */
    protected $attributes = [
        'key' => null,
        'entry' => null,
        'table' => null,
        'columns' => [], //Collection
        'buttons' => [], //Collection
    ];

    protected $properties = [
        'columns' => [
            'type' => 'collection',
        ],
        'buttons' => [
            'type' => 'collection',
            'config' => [
                'abstract' => ButtonCollection::class,
            ],
        ],
    ];
}
