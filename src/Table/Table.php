<?php

namespace Streams\Ui\Table;

use Streams\Ui\Table\View\View;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Table\Filter\Filter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Table\View\ViewCollection;
use Streams\Ui\Table\Action\ActionCollection;
use Streams\Ui\Table\Filter\FilterCollection;

/**
 * @property \Illuminate\Support\Collection|\Streams\Ui\Table\Row\Row[] $rows
 * @property \Illuminate\Support\Collection|\Streams\Ui\Button\Button[] $buttons
 * @property \Illuminate\Support\Collection|\Streams\Ui\Table\Column\Column[] $columns
 * @property \Streams\Ui\Table\View\ViewCollection|\Streams\Ui\Table\View\View[] $views
 * @property \Streams\Ui\Table\Action\ActionCollection|\Streams\Ui\Table\Action\Action[] $actions
 * @property \Streams\Ui\Table\Filter\FilterCollection|\Streams\Ui\Table\Filter\Filter[] $filters
 */
class Table extends Component
{

    public string $builder = TableBuilder::class;

    public function initializeComponentPrototype(array $attributes = [])
    {
        $this->loadPrototypeProperties([
            'views' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => ViewCollection::class,
                ],
            ],
            'actions' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => ActionCollection::class,
                ],
            ],
            'filters' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => FilterCollection::class,
                ],
            ],

            'attributes' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            
            'rows' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'buttons' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'columns' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'headers' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'entries' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'options' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
        ]);

        parent::initializeComponentPrototype(array_merge([
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

    public function post()
    {
        $this->fire('posting', [
            'table' => $this,
        ]);

        $this->detect();
        $this->handle();

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

    public function authorize()
    {

        /**
         * Configured policy options
         * take precedense over the
         * model policy.
         */
        $policy = $this->options->get('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         *
         * @todo Use stream here instead
         */
        $model = null; //$this->model;

        if ($model && !Gate::allows('viewAny', $model)) {
            abort(403);
        }
    }
}
