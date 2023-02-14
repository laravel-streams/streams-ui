<?php

namespace Streams\Ui\Components\Table;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class TableHeader extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.table.header';
    
    public ?string $text = null;
    
    public bool $sortable = false;
    
    public ?string $ordered = null; // asc|desc

    public array $attributes = [];
}
