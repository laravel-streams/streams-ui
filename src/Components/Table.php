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
        $this->stream = Request::segment(2);

        $this->entries = $this->stream()->entries()->get()->all();

        $tables = new Collection(Arr::get($this->stream()?->ui, 'tables', []));

        $table = $tables->where('handle', $this->handle)->first();

        if (!$this->columns && $table && isset($table['columns'])) {
            $this->columns = $table['columns'];
        }

        if (!$this->buttons && $table && isset($table['buttons'])) {
            $this->buttons = $table['buttons'];
        }
    }
}
