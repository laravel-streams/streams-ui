<?php

namespace Streams\Ui\Components\Workflows;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Streams\Ui\Components\Table;
use Streams\Core\Support\Workflow;

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
        $component->entries = $component->stream()->entries()->get()->all();
    }
}
