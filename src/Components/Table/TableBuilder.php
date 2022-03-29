<?php

namespace Streams\Ui\Components\Table;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Value;
use Streams\Ui\Support\Builder;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Ui\Components\Table\Row\Row;
use Streams\Ui\Components\Table\View\View;
use Streams\Ui\Components\Table\Action\Action;
use Streams\Ui\Components\Table\Column\Column;
use Streams\Ui\Components\Table\Filter\Filter;
use Streams\Ui\Components\Table\View\ViewHandler;

class TableBuilder extends Builder
{
    public function process(array $payload = []): void
    {
        $this->addStep('make_views', self::class . '@makeViews');
        // $this->addStep('detect_view', self::class . '@detectView');
        // $this->addStep('apply_view', self::class . '@applyView');

        $this->addStep('make_filters', self::class . '@makeFilters');
        $this->addStep('load_filters', self::class . '@loadFilters');

        $this->addStep('load_entries', self::class . '@loadEntries');

        //$thiscomponent->addStep('authorize', self::class . '@authorize');

        $this->addStep('make_actions', self::class . '@makeActions');
        $this->addStep('make_buttons', self::class . '@makeButtons');
        $this->addStep('make_columns', self::class . '@makeColumns');
        $this->addStep('make_rows', self::class . '@makeRows');

        parent::process($payload);
    }

    public function makeViews(Component $component)
    {
        $component->views = $component->views()->collect()->map(function ($view) use ($component) {

            $view['table'] = $component->table;

            return new View($view);
        });
    }

    public function makeFilters(Component $component)
    {
        $component->filters = $component->filters()->collect()->map(function ($view) use ($component) {

            $view['table'] = $component->table;

            return new Filter($view);
        });
    }

    public function loadEntries(Component $component)
    {
        if ($component->entries && $component->entries()->isNotEmpty()) {
            return;
        }

        if (!$component->stream) {
            return;
        }

        /**
         * Start Query
         */
        $component->criteria = $component->stream->repository()->newCriteria();

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

        foreach ($component->config()->get('order_by', []) as $name => $sort) {
            $component->criteria->orderBy($name, $sort);
        }

        /**
         * Finish query
         */
        $component->config['total_results'] = $component->criteria->count();

        $component->pagination = $component->criteria->paginate([
            'page_name' => $component->config()->get('prefix') . 'page',
            'limit_name' => $component->config()->get('limit') . 'limit',
            'total_results' => $component->config()->get('total_results'),
        ]);

        $component->entries = $component->pagination->getCollection();
    }

    public function makeActions(Component $component)
    {
        $component->actions = $component->actions()->collect()->map(function ($action) use ($component) {

            $action['table'] = $component->table;

            return new Action($action);
        });
    }

    public function makeButtons(Component $component)
    {
        $component->buttons = $component->buttons()->collect()->map(function ($button) use ($component) {

            $button['table'] = $component->table;

            if (!isset($button['attributes']['href'])) {
                $button['attributes']['href'] = URL::current() . '/{entry.id}/' . $button['handle'];
            }

            return new Button($button);
        });
    }

    public function makeColumns(Component $component)
    {
        $component->columns = $component->columns()->collect()->map(function ($column) use ($component) {

            $column['table'] = $component;
            $column['stream'] = $component->stream;

            $column['value'] = Arr::get($column, 'value', $column['handle']);

            $column['attributes'] = Arr::get($column, 'attributes', []);

            if (!isset($column['attributes']['href'])) {
                $column['attributes']['href'] = URL::current() . '/{entry.id}/' . $column['handle'];
            }

            return new Column($column);
        });

        if ($component->columns->isEmpty()) {
            $component->columns = $component->columns->put('id', new Column([
                'value' => 'id',
                'handle' => 'id',
                'heading' => 'ID',
            ]));
        }
    }

    public function makeRows(Component $component)
    {
        $rows = $component->entries()->collect()->map(function ($entry) use ($component) {
            return new Row([
                'handle' => $entry->id,
                'key' => $entry->id,

                'entry' => $entry,
                'table' => $component,

                'stream' => $component->stream,

                'columns' => $component->columns->map(function ($column) {
                    return clone ($column);
                })->keyBy('handle'),
                'buttons' => $component->buttons->map(function ($button) {
                    return clone ($button);
                })->keyBy('handle'),
            ]);
        });

        $rows->each(function ($row) use ($component) {

            $row->columns = $row->columns->each(function ($column) use ($row) {
                $column->value = Value::make($column->value, $row->entry);
            });

            $row->buttons = $component->buttons->map(function ($button) use ($row, $component) {

                $clone = clone ($button);

                $clone->setPrototypeAttributes(Arr::parse(Hydrator::dehydrate($button), [
                    'entry' => $row->entry,
                    'stream' => $component->stream,
                ]));

                return $clone;
            });
        });

        $component->rows = $rows;
    }

    public function detectView(Component $component)
    {
        if ($component->views()->active()) {
            return;
        }

        if ($view = $component->views()->findByHandle(Request::get($component->options->get('prefix') . 'view'))) {
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

            $value = Request::get(Arr::get($component->options, 'prefix') . $filter->handle);

            if ($filter->active = ($value !== null)) {
                $filter->value = $value;
            }
        });
    }
}
