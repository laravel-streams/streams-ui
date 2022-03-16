<?php

namespace Streams\Ui\Table\Row;

use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Ui\Button\ButtonCollection;

/**
 * Class Row
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @typescript
 * @property Collection|\Streams\Ui\Table\Column\Column[] $columns
 * @property ButtonCollection|\Streams\Ui\Button\Button[] $buttons
 * @property string|int $key
 * @property \Streams\Core\Entry\Entry $entry
 * @property \Streams\Ui\Table\Table $table
 */
class Row extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeElementPrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
            'columns' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'buttons' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => ButtonCollection::class,
                ],
            ],
        ]);

        return parent::initializeElementPrototype(array_merge([
            'key' => null,
            'entry' => null,
            'table' => null,
            'columns' => Collection::class, //Collection
            'buttons' => ButtonCollection::class, //Collection
        ], $attributes));
    }
}
