<?php

namespace Streams\Ui\Components\Table;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Value;
use Streams\Ui\Support\Builder;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Components\Table\Row\Row;
use Streams\Ui\Components\Table\View\View;
use Streams\Ui\Components\Table\Action\Action;
use Streams\Ui\Components\Table\Column\Column;
use Streams\Ui\Components\Table\Filter\Filter;
use Streams\Ui\Components\Table\View\ViewHandler;

class TableBuilder extends Builder
{
    public array $steps = [
        'cast_stream' => self::class . '@castStream',
        'load_attributes' => self::class . '@loadAttributes',

        'make_views' => self::class . '@makeViews',
        'detect_view' => self::class . '@detectView',
        'apply_view' => self::class . '@applyView',
        'make_filters' => self::class . '@makeFilters',
        'load_filters' => self::class . '@loadFilters',
        'load_entries' => self::class . '@loadEntries',
        'make_actions' => self::class . '@makeActions',
        'make_buttons' => self::class . '@normalizeButtons',
        'make_columns' => self::class . '@normalizeColumns',
        'make_rows' => self::class . '@makeRows',
    ];

    public function makeViews(Component $component, Collection $attributes)
    {
        $component->views = collect($attributes->pull('views', []))->map(function ($view) use ($component) {

            $view['table'] = $component->table;

            return new View($view);
        });
    }

    public function makeFilters(Component $component, Collection $attributes)
    {
        $component->filters = collect($attributes->pull('filters', []))->map(function ($view) use ($component) {

            $view['table'] = $component->table;

            return new Filter($view);
        });
    }

    public function loadEntries(Component $component, Collection $attributes)
    {
        if ($component->entries && !$component->entries) {
            return;
        }

        if (!$component->stream) {
            return;
        }

        /**
         * Start Query
         */
        $component->criteria = $component->stream->repository()->newCriteria();

        // @todo needs work
        $component->fire('querying', [
            'component' => $component,
        ]);

        // @todo move this somewhere nice
        if ($view = $component->views()->active()) {

            foreach ((array) $view->criteria as $step) {

                if (is_string($step)) {
                    // App::call($step, [
                    //     'query' => $component->criteria,
                    //     'table' => $component,
                    //     'view' => $view,
                    // ], 'handle');
                }

                if (is_array($step)) {
                    foreach ($step as $method => $arguments) {
                        $component->criteria->{$method}(...$arguments);
                    }
                }
            }
        }

        /**
         * Filter Query
         */
        foreach ($component->getPrototypeAttribute('filters')->active() as $filter) {

            /*
            * If the handler is a callable string or Closure
            * then call it using the IoC container.
            */
            $query = $filter->query ?: [$filter, 'query'];

            App::call($query, [
                'table' => $component,
                'filter' => $filter,
            ], 'handle');
        }

        /**
         * Order query
         */
        if ($name = $component->request('order_by')) {
            $component->criteria->orderBy($name, $component->request('sort', 'asc'));
        }

        foreach ($component->config()->get('order_by', []) as $order) {
            $component->criteria->orderBy(...$order);
        }

        /**
         * Finish query
         */
        $total = $component->criteria->count();

        $config = $component->getPrototypeAttribute('config');

        $config['total_results'] = $total;

        $component->setPrototypeAttribute('config', $config);



        $component->pagination = $component->criteria->paginate([
            'page_name' => $component->config()->get('prefix') . 'page',
            'limit_name' => $component->config()->get('limit') . 'limit',
            'total_results' => $component->config()->get('total_results'),
        ]);

        $component->entries = $component->pagination->getCollection();
    }

    public function makeActions(Component $component, Collection $attributes)
    {
        $component->actions = collect($attributes->pull('actions', []))->map(function ($action) use ($component) {

            $action['table'] = $component->table;

            return new Action($action);
        });
    }

    public function normalizeButtons(Component $component, Collection $attributes)
    {
        $component->buttons = collect($attributes->pull('buttons', []))->map(function ($button) use ($component) {

            $button['table'] = $component->table;

            $keyName = $component->stream->config('key_name', 'id');

            if (!isset($button['attributes']['href'])) {
                $button['attributes']['href'] = URL::current() . "/{entry.$keyName}/" . $button['handle'];
            }

            return $button;
        });
    }

    public function normalizeColumns(Component $component, Collection $attributes)
    {
        $component->columns = collect($attributes->pull('columns', []))->map(function ($column) use ($component) {

            $column['table'] = $component;
            $column['stream'] = $component->stream;

            $column['value'] = Arr::get($column, 'value', $column['handle']);

            $column['attributes'] = Arr::get($column, 'attributes', []);

            if (Request::get($component->prefix('order_by')) == $column['handle']) {
                $column['direction'] = Request::get($component->prefix('sort'), 'asc');
            }

            if (!isset($column['attributes']['href'])) {
                $column['attributes']['href'] = URL::current() . '/{entry.id}/' . $column['handle'];
            }

            return $column;
        });

        if ($component->columns->isEmpty()) {
            $component->columns = $component->columns->put('id', [
                'value' => 'id',
                'handle' => 'id',
                'heading' => 'ID',
                'attributes' => [],
            ]);
        }
    }

    public function makeRows(Component $component)
    {
        $rows = $component->entries()->collect()->map(function ($entry) use ($component) {

            $keyName = $component->stream->config('key_name', 'id');

            return new Row([
                'handle' => $entry->{$keyName},
                'key' => $entry->{$keyName},

                'entry' => $entry,
                'table' => $component,

                'stream' => $component->stream,
                'table' => $component,

                'columns' => $component->columns->keyBy('handle'),
                'buttons' => $component->buttons->keyBy('handle'),
            ]);
        });

        $rows->each(function ($row) use ($component) {

            $row->columns = $row->columns->map(function ($column) use ($row) {

                $column['value'] = Value::make($column, $row->entry);

                return new Column($column);
            });

            $row->buttons = $component->buttons->map(function ($button) use ($row, $component) {

                $clone = $button;

                $clone = Arr::parse($clone, [
                    'entry' => $row->entry,
                    'stream' => $component->stream,
                ], ['entry' => Arr::make($row->entry)]);
                
                return new Button($clone);
            });
        });

        $component->rows = $rows;

        $columns = $component->columns->all();

        foreach ($columns as &$column) {
            $column =  new Column($column);
        }

        $component->columns = collect($columns);
    }

    public function detectView(Component $component)
    {
        if ($component->views()->active()) {
            return;
        }

        if ($view = $component->views()->findByHandle(Request::get($component->prefix('view')))) {
            $view->active = true;
        }

        if (!$view && $view = $component->views()->first()) {
            $view->active = true;
        }
    }

    public function applyView(Component $component, ViewHandler $handler)
    {
        if (!$active = $component->views()->active()) {
            return;
        }

        if ($active->filters) {
            $component->filters = $active->filters;
        }

        if ($active->columns) {
            $component->columns = $active->columns;
        }

        if ($active->buttons) {
            $component->buttons = $active->buttons;
        }

        if ($active->actions) {
            $component->actions = $active->actions;
        }

        if ($active->options) {
            $component->options = $active->options;
        }

        if ($active->entries) {
            $component->entries = $active->entries;
        }

        $handler->handle($this, $active);
    }

    public function loadFilters(Component $component)
    {
        $component->filters->each(function ($filter) use ($component) {

            $value = Request::get($filter->inputName());

            if ($filter->active = ($value !== null)) {
                $filter->value = $value;
            }
        });
    }
}
