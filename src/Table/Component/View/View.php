<?php

namespace Streams\Ui\Table\Component\View;

use Streams\Ui\Support\Component;

/**
 * Class View
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class View extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeInstance(array $attributes)
    {
        return parent::initializePrototypeInstance(array_merge([
            'component' => 'view',
            'template' => 'ui::tables.view',

            'handle' => null,
            'text' => null,
            'icon' => null,
            'label' => null,
            'query' => null,
            'prefix' => null,
            'actions' => null,
            'buttons' => null,
            'columns' => null,
            'entries' => null,
            'filters' => null,
            'handler' => null,
            'options' => null,
            'active' => false,
            'context' => 'danger',
            
            'classes' => [
                'ls-table__view',
            ],
            'attributes' => [],

            'query' => ViewQuery::class,
            'handler' => ViewHandler::class,
        ], $attributes));
    }
}
