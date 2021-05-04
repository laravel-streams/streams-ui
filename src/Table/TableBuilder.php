<?php

namespace Streams\Ui\Table;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Button\Button;
use Streams\Ui\Support\Value;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Normalizer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\Row\Row;
use Streams\Ui\Table\View\View;
use Streams\Ui\Table\Action\Action;
use Streams\Ui\Table\Column\Column;
use Streams\Ui\Table\Filter\Filter;
use Streams\Ui\Table\View\ViewHandler;
use Streams\Ui\Table\View\ViewRegistry;
use Streams\Ui\Table\Action\ActionRegistry;
use Streams\Ui\Table\Button\ButtonRegistry;
use Streams\Ui\Table\Filter\FilterRegistry;
use Streams\Core\Repository\Contract\RepositoryInterface;

class TableBuilder extends Builder
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'stream' => null,
            'entries' => null,
            'repository' => null,

            'views' => [],
            'assets' => [],
            'filters' => [],
            'columns' => [],
            'headers' => [],
            'buttons' => [],
            'actions' => [],

            'config' => [
                'auto_query' => true,
            ],

            'component' => 'table',
            'table' => Table::class,

            'steps' => [
                //'make_views' => [$this, 'makeViews'],
                'detect_view' => [$this, 'detectView'],
                'apply_view' => [$this, 'applyView'],

                'authorize_table' => [$this, 'authorizeTable'],

                //'make_filters' => [$this, 'makeFilters'],
                'detect_filters' => [$this, 'detectFilters'],
                //'query_entries' => [$this, 'queryEntries'],

                //'make_actions' => [$this, 'makeActions'],
                'make_buttons' => [$this, 'makeButtons'],
                'make_columns' => [$this, 'makeColumns'],
                'make_rows' => [$this, 'makeRows'],
            ],
        ], $attributes));
    }

    public function detectView()
    {
        if ($this->instance->views->active()) {
            return;
        }

        if ($view = $this->instance->views->findByHandle(Request::get($this->instance->options->get('prefix') . 'view'))) {
            $view->active = true;
        }

        if (!$view && $view = $this->instance->views->first()) {
            $view->active = true;
        }
    }

    public function applyView(ViewHandler $handler)
    {
        if (!$active = $this->instance->views->active()) {
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

    public function authorizeTable(TableAuthorizer $authorizer)
    {
        if (!$authorizer->authorize($this)) {
            abort(403);
        }
    }

    public function detectFilters()
    {
        $this->instance->filters->each(function ($filter) {
            $filter->active = Request::has($this->instance->prefix(/*'filter_' .*/$filter->handle));
        });
    }
}
