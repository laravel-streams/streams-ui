<?php

namespace Streams\Ui\Table;

use Streams\Ui\Support\Component;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Button\ButtonCollection;
use Streams\Ui\Table\View\ViewCollection;
use Streams\Ui\Table\Action\ActionCollection;
use Streams\Ui\Table\Filter\FilterCollection;

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
    protected function initializePrototypeAttributes(array $attributes)
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
            'headers' => [
                'type' => 'collection',
            ],
            'entries' => [
                'type' => 'collection',
            ],
            'options' => [
                'type' => 'collection',
            ],
        ]);

        parent::initializePrototypeAttributes(array_merge([
            'component' => 'table',
            'template' => 'ui::tables.table',

            'views' => [],
            'filters' => [],
            'columns' => [],
            'buttons' => [],
            'actions' => [],
            'options' => [],

            'entries' => [],
            'rows' => [],

            'class' => null,
            'classes' => [],

            'attributes' => [],
        ], $attributes));
    }

    public function isSelectable(): bool
    {
        return ($this->actions->isNotEmpty() || $this->options->get('selectable'));
    }

    public function isSortable(): bool
    {
        return (bool) $this->options->get('sortable');
    }

    public function post()
    {
        $workflow = (new Workflow([
            'detect' => [$this, 'detect'],
            'handle' => [$this, 'handle'],
        ]))->passThrough($this);

        $this->fire('posting', [
            'table' => $this,
            'workflow' => $workflow
        ]);

        $workflow->process([
            'table' => $this,
            'workflow' => $workflow
        ]);

        $this->fire('posted', [
            'table' => $this
        ]);

        return $this;
    }

    public function detect()
    {
        if ($this->actions->active()) {
            return;
        }

        if ($action = $this->actions->get($this->request('action'))) {
            $action->active = true;
        }
    }

    public function handle()
    {
        if (!$active = $this->actions->active()) {
            return;
        }

        $selected = (array) $this->request('selected');

        $active->handle([
            'table' => $this,
            'selected' => $selected,
        ]);
    }

    public function clearUrl()
    {
        return URL::current() . (Request::has('view') ? '?view=' . Request::get('view') : '');
    }
}
