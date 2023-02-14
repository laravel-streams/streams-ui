<?php

namespace Streams\Ui\Components\Table;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class TableRow extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.table.row';

    public array $entry = [];
    
    public array $columns = [];
    public array $buttons = [];

    public array $attributes = [];

    public function booted()
    {
        $this->columns = Arr::parse($this->columns, [
            'entry' => $this->entry,
        ]);

        $this->buttons = Arr::parse($this->buttons, [
            'entry' => $this->entry,
        ]);
    }
}
