<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Components\Table\TableBuilder;
use Streams\Ui\Components\Table\View\ViewCollection;
use Streams\Ui\Components\Table\Action\ActionCollection;
use Streams\Ui\Components\Table\Filter\FilterCollection;

class Table extends Component
{
    public string $component = 'table';
    public string $builder = TableBuilder::class;
    public string $template = 'ui::components.table';

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => ViewCollection::class,
        ],
    ])]
    public $views;

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => ActionCollection::class,
        ],
    ])]
    public $actions;

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => FilterCollection::class,
        ],
    ])]
    public $filters;

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public $columns;

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public $buttons;

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public $entries;

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public $rows;

    public function post(): void
    {
        $this->fire('posting', [
            'table' => $this,
        ]);

        $this->detect();
        $this->handle();

        $this->fire('posted', [
            'table' => $this
        ]);
    }

    protected function detect(): void
    {
        if ($this->actions->active()) {
            return;
        }

        if ($action = $this->actions->get($this->request('action'))) {
            $action->active = true;
        }
    }

    protected function handle(): void
    {
        $active = $this->actions->active();

        $selected = (array) $this->request('selected');

        $handler = $this->post;

        if (!$handler && !$active->handler) {
            return;
        }

        App::call($handler ?: $active->handler, [
            'table' => $this,
            'action' => $active,
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
        $policy = $this->config->get('policy');

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

    public function url(array $extra = [])
    {
        $type = Str::singular($this->component);
        $default = "ui/{$this->stream->handle}/{$type}/{$this->handle}";

        return URL::cp(Arr::get($this->config, 'url', $default), $extra);
    }
}
