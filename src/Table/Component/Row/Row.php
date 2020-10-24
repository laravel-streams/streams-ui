<?php

namespace Streams\Ui\Table\Component\Row;

use Streams\Ui\Support\Component;
use Streams\Ui\Button\ButtonCollection;
use Illuminate\Support\Collection;

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
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
            'columns' => [
                'type' => 'collection',
            ],
            'buttons' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ButtonCollection::class,
                ],
            ],
        ]);
        
        return parent::initializePrototype(array_merge([
            'key' => null,
            'entry' => null,
            'table' => null,
            'columns' => Collection::class, //Collection
            'buttons' => ButtonCollection::class, //Collection
        ], $attributes));
    }
}
