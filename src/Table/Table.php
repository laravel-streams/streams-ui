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
use Streams\Ui\Button\ButtonCollection;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Table\View\ViewCollection;
use Streams\Ui\Support\Traits\HasRepository;
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

    use HasRepository;

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

    /**
     * Return if the rows are selectable or not.
     *
     * @return bool
     */
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

    public function onInitializing($callbackData)
    {
        $attributes = $callbackData->get('attributes');

        if (isset($attributes['stream']) && is_string($attributes['stream']) && !$attributes['stream'] instanceof Stream) {
            $attributes['stream'] = Streams::make($attributes['stream']);
        }

        $this->options = new Collection(Arr::get($attributes, 'options', []));

        $this->stream = Arr::get($attributes, 'stream');

        $this->makeViews($attributes);
        // $this->detectView($attributes);
        // $this->applyView($attributes);

        $this->makeFilters($attributes);
        
        $this->query($attributes);

        //$this->authorize($attributes);

        $this->makeActions($attributes);
        $this->makeButtons($attributes);
        $this->makeColumns($attributes);
        $this->makeRows($attributes);

        $callbackData->put('attributes', $attributes);
    }

    public function query(array $attributes)
    {

        /**
         * Start Query
         */
        $this->criteria = $this->repository()->newCriteria();

        /**
         * Filter Query
         */
        foreach ((new FilterCollection($attributes['filters']))->active() as $filter) {

            /*
            * If the handler is a callable string or Closure
            * then call it using the IoC container.
            */
            $query = $filter->query ?: [$filter, 'query'];

            App::call($query, [
                'table' => $this,
                'filter' => $filter,
            ], 'handle');
        }

        /**
         * Order query
         */
        if ($name = $this->request('order_by')) {
            $this->criteria->orderBy($name, $this->request('sort', 'asc'));
        }

        foreach ($this->options->get('order_by', []) as $name => $sort) {
            $this->criteria->orderBy($name, $sort);
        }

        /**
         * Finish query
         */
        $this->options['total_results'] = $total = $this->criteria->count();

        /**
         * @todo This terminology and parameters need reviewed/revisited.
         */
        if ($this->options->get('paginate', true)) {

            $this->pagination = $this->criteria->paginate([
                'page_name' => $this->options->get('prefix') . 'page',
                'limit_name' => $this->options->get('limit') . 'limit',
                'total_results' => $this->options->get('total_results'),
            ]);

            $this->entries = $this->pagination->getCollection();
        }
    }

    public function makeViews(array &$attributes)
    {
        $views = Arr::get($attributes, 'views', []);

        /**
         * Minimal standardization
         */
        array_walk($views, function (&$view, $key) use ($attributes) {

            $view = is_string($view) ? [
                'view' => $view,
            ] : $view;

            $view['handle'] = Arr::get($view, 'handle', $key);

            $view['stream'] = $attributes['stream'];

            $view = new View($view);
        });

        $attributes['views'] = $views;
    }

    public function makeFilters(array &$attributes)
    {
        $filters = Arr::get($attributes, 'filters', []);

        /**
         * Minimal standardization
         */
        array_walk($filters, function (&$filter, $key) use ($attributes) {

            $filter = is_string($filter) ? [
                'filter' => $filter,
            ] : $filter;

            $filter['handle'] = Arr::get($filter, 'handle', $key);

            $filter['stream'] = $attributes['stream'];

            $value = Request::get(Arr::get($attributes, 'options.prefix').$filter['handle']);

            if ($filter['active'] = (bool) $value) {
                $filter['value'] = $value;
            }

            $filter = new Filter($filter);
        });

        $attributes['filters'] = $filters;
    }

    public function makeActions(array &$attributes)
    {
        $actions = Arr::get($attributes, 'actions', []);

        /**
         * Minimal standardization
         */
        array_walk($actions, function (&$action, $key) use ($attributes) {

            $action = is_string($action) ? [
                'action' => $action,
            ] : $action;

            $action['handle'] = Arr::get($action, 'handle', $key);

            $action['stream'] = $attributes['stream'];

            $action = new Action($action);
        });

        $attributes['actions'] = $actions;
    }

    public function makeButtons(array &$attributes)
    {
        $buttons = Arr::get($attributes, 'buttons', []);

        /**
         * Minimal standardization
         */
        array_walk($buttons, function (&$button, $key) use ($attributes) {

            $button = is_string($button) ? [
                'button' => $button,
            ] : $button;

            $button['handle'] = Arr::get($button, 'handle', $key);

            $button['stream'] = $this->stream;

            $button['attributes'] = Arr::get($button, 'attributes', []);

            if (
                isset($button['handle'])
                && !isset($button['attributes']['href'])
            ) {
                $button['attributes']['href'] = URL::current() . '/{entry.id}/' . $button['handle'];
            }

            $button = new Button($button);
        });

        $attributes['buttons'] = $buttons;
    }

    public function makeColumns(array &$attributes)
    {
        $columns = Arr::get($attributes, 'columns', [
            'id' => [],
        ]);

        /**
         * Minimal standardization
         */
        array_walk($columns, function (&$column, $key) {

            $column = is_string($column) ? [
                'column' => $column,
            ] : $column;

            $column['handle'] = Arr::get($column, 'handle', $key);

            $column['value'] = Arr::get($column, 'value', $column['handle']);

            $column['stream'] = $this->stream;

            $column['attributes'] = Arr::get($column, 'attributes', []);

            $column = new Column($column);
        });

        $attributes['columns'] = $columns;
    }

    public function makeRows(array &$attributes)
    {
        $rows = $this->entries->map(function ($entry) use ($attributes) {
            return new Row([
                'handle' => $entry->id,
                'key' => $entry->id,

                'entry' => $entry,
                'table' => $this->instance,

                'columns' => collect($attributes['columns'])->map(function ($column) {
                    return clone ($column);
                }),
                'buttons' => (new ButtonCollection($attributes['buttons']))->map(function ($button) {
                    return clone ($button);
                }),
            ]);
        });

        $rows->each(function ($row) use ($attributes) {

            // Load Columns
            foreach (Arr::get($attributes, 'columns') ?: [] as $key => $column) {

                $clone = clone ($column);

                $clone->value = Value::make($clone->value, $row->entry);

                $row->columns->put($key, $clone);
            }

            // Load Buttons
            foreach (Arr::get($attributes, 'buttons') ?: [] as $button) {

                $clone = clone ($button);

                $clone->setPrototypeAttributes(Arr::parse($button->getPrototypeAttributes(), [
                    'entry' => $row->entry,
                    'stream' => $this->stream,
                ]));

                $row->buttons->put($clone->handle, $clone);
            }
        });

        $attributes['rows'] = $rows;
    }

    public function detectView()
    {
        if ($this->views->active()) {
            return;
        }

        if ($view = $this->views->findByHandle(Request::get($this->options->get('prefix') . 'view'))) {
            $view->active = true;
        }

        if (!$view && $view = $this->views->first()) {
            $view->active = true;
        }
    }

    public function applyView(ViewHandler $handler)
    {
        if (!$active = $this->views->active()) {
            return;
        }

        // Nothing to do.
        if (!$active) {
            return;
        }

        if ($active->filters) {
            $this->filters = $active->filters;
        }

        if ($active->columns) {
            $this->columns = $active->columns;
        }

        if ($active->buttons) {
            $this->buttons = $active->buttons;
        }

        if ($active->actions) {
            $this->actions = $active->actions;
        }

        if ($active->options) {
            $this->options = $active->options;
        }

        if ($active->entries) {
            $this->entries = $active->entries;
        }

        $handler->handle($this, $active);
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
