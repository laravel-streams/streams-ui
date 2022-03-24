<?php

namespace Streams\Ui\Table;

use Illuminate\Support\Arr;
use Streams\Ui\Button\Button;
use Streams\Ui\Support\Value;
use Streams\Ui\Table\Row\Row;
use Streams\Ui\Support\Builder;
use Streams\Ui\Table\View\View;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Table\Action\Action;
use Streams\Ui\Table\Column\Column;
use Streams\Ui\Table\Filter\Filter;
use Streams\Ui\Table\View\ViewHandler;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\Filter\FilterCollection;

class TableBuilder extends Builder
{
    public function process(array $payload = []): void
    {
        //$this->addStep('make_views', self::class . '@makeViews');
        // $this->addStep('detect_view', self::class . '@detectView');
        // $this->addStep('apply_view', self::class . '@applyView');

        //$this->addStep('make_filters', self::class . '@makeFilters');

        $this->addStep('query', self::class . '@query');

        //$thiscomponent->addStep('authorize', self::class . '@authorize');

        $this->addStep('make_actions', self::class . '@makeActions');
        $this->addStep('make_buttons', self::class . '@makeButtons');
        $this->addStep('make_columns', self::class . '@makeColumns');
        $this->addStep('make_rows', self::class . '@makeRows');

        parent::process($payload);
    }

    public function query(Component $component, Collection $attributes)
    {

        /**
         * Start Query
         */
        $component->criteria = $component->stream->repository()->newCriteria();

        /**
         * Filter Query
         */
        foreach ($component->filters->active() as $filter) {

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

        foreach ($component->options->get('order_by', []) as $name => $sort) {
            $component->criteria->orderBy($name, $sort);
        }

        /**
         * Finish query
         */
        $component->options['total_results'] = $total = $component->criteria->count();

        /**
         * @todo This terminology and parameters need reviewed/revisited.
         */
        if ($component->options->get('paginate', true)) {

            $component->pagination = $component->criteria->paginate([
                'page_name' => $component->options->get('prefix') . 'page',
                'limit_name' => $component->options->get('limit') . 'limit',
                'total_results' => $component->options->get('total_results'),
            ]);

            $component->entries = $component->pagination->getCollection();
        }
    }

    public function makeActions(Component $component, Collection $attributes)
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

        $component->actions = $actions;
    }

    public function makeButtons(Component $component, Collection $attributes)
    {
        $buttons = Arr::get($attributes, 'buttons', []);

        /**
         * Minimal standardization
         */
        array_walk($buttons, function (&$button, $key) use ($component) {

            $button = is_string($button) ? [
                'button' => $button,
            ] : $button;

            $button['handle'] = Arr::get($button, 'handle', $key);

            $button['stream'] = $component->stream;

            $button['attributes'] = Arr::get($button, 'attributes', []);

            if (
                isset($button['handle'])
                && !isset($button['attributes']['href'])
            ) {
                $button['attributes']['href'] = URL::current() . '/{entry.id}/' . $button['handle'];
            }

            $button = new Button($button);
        });

        $component->buttons = $buttons;
    }

    public function makeColumns(Component $component, Collection $attributes)
    {
        $columns = Arr::get($attributes, 'columns', [
            'id' => [],
        ]);

        /**
         * Minimal standardization
         */
        array_walk($columns, function (&$column, $key) use ($component) {

            $column = is_string($column) ? [
                'column' => $column,
            ] : $column;

            $column['handle'] = Arr::get($column, 'handle', $key);

            $column['value'] = Arr::get($column, 'value', $column['handle']);

            $column['stream'] = $component->stream;

            $column['attributes'] = Arr::get($column, 'attributes', []);

            $column = new Column($column);
        });

        $component->columns = $columns;
    }

    public function makeRows(Component $component, Collection $attributes)
    {
        $rows = $component->entries->map(function ($entry) use ($component, $attributes) {
            return new Row([
                'handle' => $entry->id,
                'key' => $entry->id,

                'entry' => $entry,
                'table' => $component->instance,

                'columns' => $component->columns->map(function ($column) {
                    return clone ($column);
                }),
                'buttons' => $component->buttons->map(function ($button) {
                    return clone ($button);
                }),
            ]);
        });

        $rows->each(function ($row) use ($component, $attributes) {

            $columns = $row->columns->keyBy('handle');

            // Load Columns
            foreach ($component->columns as $column) {

                $clone = clone ($column);

                $clone->value = Value::make($clone->value, $row->entry);

                $columns->put($column->handle, $clone);
            }

            $row->columns = $columns;

            $buttons = $row->buttons->keyBy('handle');

            // Load Buttons
            foreach ($columns->get('buttons', []) as $button) {

                $clone = clone ($button);

                $clone->setPrototypeAttributes(Arr::parse($button->getPrototypeAttributes(), [
                    'entry' => $row->entry,
                    'stream' => $component->stream,
                ]));

                $buttons->put($clone->handle, $clone);
            }

            $row->buttons = $buttons;
        });

        $component->rows = $rows;
    }

    public function detectView(Component $component)
    {
        if ($component->views->active()) {
            return;
        }

        if ($view = $component->views->findByHandle(Request::get($component->options->get('prefix') . 'view'))) {
            $view->active = true;
        }

        if (!$view && $view = $component->views->first()) {
            $view->active = true;
        }
    }

    public function applyView(Component $component, ViewHandler $handler)
    {
        if (!$active = $component->views->active()) {
            return;
        }

        // Nothing to do.
        if (!$active) {
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
}
