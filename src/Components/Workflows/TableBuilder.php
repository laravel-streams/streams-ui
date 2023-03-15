<?php

namespace Streams\Ui\Components\Workflows;

use Illuminate\Support\Arr;
use Streams\Ui\Components\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Workflow;

class TableBuilder extends Workflow
{
    public array $steps = [
        'load_stream_config' => self::class . '@loadStreamConfig',
        'load_view_config' => self::class . '@loadViewConfig',
        'query_entries' => self::class . '@queryEntries',
        'set_defaults' => self::class . '@setDefaults',
    ];

    /**
     * Load the configuration from the stream.
     */
    public function loadStreamConfig(Table $component): void
    {
        if (!$stream = $component->stream()) {
            return;
        }

        $tables = new Collection(Arr::get($stream?->ui, 'components', []));

        $table = $tables
            ->where('component', 'table')
            ->where('handle', $component->handle)
            ->first();

        unset($table['component']);

        if ($table) {
            foreach ($table as $key => $value) {
                $component->{$key} = $value;
            }
        }
    }

    public function loadViewConfig(Table $component): void
    {
        if (!$active = Request::get('view')) {
            return;
        }

        $view = $component->decoratePrototypeAttribute('views')
            ->where(function ($view) use ($active) {
                return $view['handle'] == $active;
            })[0] ?? null;

        $attributes = [
            'columns',
            'filters',
            'buttons',
            'actions',
        ];

        foreach ($attributes as $attribute) {
            if (isset($view[$attribute])) {
                $component->{$attribute} = $view[$attribute];
            }
        }
    }

    public function setDefaults(Table $component): void
    {
        if (!$component->columns) {

            $component->columns = [
                [
                    'heading' => [
                        'text' => 'ID',
                    ],
                    'value' => $component->stream()?->config('key_name') ?: 'id',
                ],
            ];
        }
    }

    public function queryEntries(Table $component): void
    {
        $query = $component->stream()->entries();

        $component->fire('querying', compact('query', 'component'));

        (new TableQuery())
            ->passThrough($this)
            ->process([
                'component' => $component,
                'query' => $query,
            ]);

        $this->fire('built', [
            'component' => $component,
        ]);

        $component->fire('queried', compact('component'));
    }
}
