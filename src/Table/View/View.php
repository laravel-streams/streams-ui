<?php

namespace Streams\Ui\Table\View;

use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Ui\Table\Action\ActionCollection;
use Streams\Ui\Table\Filter\FilterCollection;

/**
 * Class View
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @typescript
 * @property string $text default ' => null,
 * @property string $icon default ' => null,
 * @property string $label default ' => null,
 * @property string $prefix default ' => null,
 * @property ActionCollection|\Streams\Ui\Table\View\View[] $actions
 * @property \Streams\Ui\Table\Column\Column[] $columns default ' => null,
 * @property \Streams\Core\Entry\Entry[] $entries default ' => null,
 * @property FilterCollection|\Streams\Ui\Table\Filter\Filter[] $filters
 * @property Collection|\Streams\Ui\Button\Button[] $buttons
 * @property ViewHandler $handler default ' => null,
 * @property ViewQuery $query default ' => null,
 * @property bool $active default ' => false,
 * @property string $context default ' => 'danger',
 */
class View extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeComponentPrototype(array $attributes)
    {
        return parent::initializeComponentPrototype(array_merge([
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
