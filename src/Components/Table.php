<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Table extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.table';

    public array $entries = [];

    public array $columns = [];
    public array $buttons = [];

    public array $attributes = [];

    public function booted()
    {
        $this->stream = Request::segment(2);

        $this->entries = $this->stream()->entries()->get()->all();
    }
}
