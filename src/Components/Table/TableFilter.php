<?php

namespace Streams\Ui\Components\Table;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class TableFilter extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.table.filter';
    
    public array $attributes = [];
}
