<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Components\Workflows\TableBuilder;

class Table extends Component
{
    use HasAttributes;

    public $workflow = TableBuilder::class;

    public string $template = 'ui::components.table';

    public string $handle = 'default';
    
    public bool $selectable = false;
    
    public ?string $caption = null;

    public array $entries = [];

    public array $columns = [];
    public array $buttons = [];

    public array $attributes = [];
}
