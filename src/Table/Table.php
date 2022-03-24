<?php

namespace Streams\Ui\Table;

use Illuminate\Support\Arr;
use Streams\Ui\Button\Button;
use Streams\Ui\Support\Value;
use Streams\Ui\Table\Row\Row;
use Streams\Core\Stream\Stream;
use Streams\Ui\Table\View\View;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Table\Action\Action;
use Streams\Ui\Table\Column\Column;
use Streams\Ui\Table\Filter\Filter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Table\View\ViewCollection;
use Streams\Ui\Table\Action\ActionCollection;
use Streams\Ui\Table\Filter\FilterCollection;

/**
 * Class Table
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 * @typescript
 * @property \Illuminate\Support\Collection|\Streams\Ui\Table\Row\Row[] $rows
 * @property \Streams\Ui\Table\View\ViewCollection|\Streams\Ui\Table\View\View[] $views
 * @property \Illuminate\Support\Collection|\Streams\Ui\Table\Column\Column[] $columns
 * @property \Streams\Ui\Table\Action\ActionCollection|\Streams\Ui\Table\Action\Action[] $actions
 * @property \Streams\Ui\Table\Filter\FilterCollection|\Streams\Ui\Table\Filter\Filter[] $filters
 * @property \Illuminate\Support\Collection|\Streams\Ui\Button\Button[] $buttons
 */
class Table extends Component
{

    public string $builder = TableBuilder::class;

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
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

    public function setViewsAttribute($value)
    {
        array_walk($value, function (&$view, $key) {

            if ($view instanceof View) {
                return;
            }

            $filter['stream'] = $this->stream;

            $view = new View($view);
        });

        $this->setPrototypeAttributeValue('views', $value);
    }

    public function setFiltersAttribute($value)
    {
        array_walk($value, function (&$filter, $key) {

            if ($filter instanceof Filter) {
                return;
            }

            $filter['stream'] = $this->stream;

            //$value = Request::get(Arr::get($attributes, 'options.prefix') . $filter['handle']);

            // if ($filter['active'] = (bool) $value) {
            //     $filter['value'] = $value;
            // }

            $filter = new Filter($filter);
        });

        $this->setPrototypeAttributeValue('filters', $value);
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
