<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Traits\HasAttributes;

class Table extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.table';

    public string $handle = 'default';

    public array $entries = [];

    public array $columns = [];
    public array $buttons = [];

    public array $attributes = [];

    public function booted()
    {
        if (!$stream = $this->stream()) {
            return;
        }

        $this->entries = $stream->entries()->get()->all();

        $tables = new Collection(Arr::get($stream?->ui, 'components', []));

        $table = $tables
            ->where('component', 'table')
            ->where('handle', $this->handle)
            ->first();

        if (!$this->columns && $table && isset($table['columns'])) {
            $this->columns = $table['columns'];
        } elseif (!$this->columns) {
            $this->columns = [
                [
                    'handle' => 'id',
                    'heading' => 'ID',
                    'field' => 'id',
                ],
            ];
        }

        if (!$this->buttons && $table && isset($table['buttons'])) {
            $this->buttons = $table['buttons'];
        }
    }
}
