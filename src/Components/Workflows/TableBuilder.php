<?php

namespace Streams\Ui\Components\Workflows;

use Illuminate\Support\Arr;
use Streams\Ui\Components\Table;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class TableBuilder extends Workflow
{
    public array $steps = [
        'load_stream_config' => self::class . '@loadStreamConfig',
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
