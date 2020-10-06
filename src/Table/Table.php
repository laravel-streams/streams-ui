<?php

namespace Anomaly\Streams\Ui\Table;

use Anomaly\Streams\Ui\Button\ButtonCollection;
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
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
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
                'config' => [
                    'abstract' => ButtonCollection::class,
                ],
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
        ]);

        parent::initializePrototype(array_merge([
            'component' => 'table',
            'template' => 'ui::components.table.index',

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
}
