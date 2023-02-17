<?php

namespace Streams\Ui\Components\Table;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Support\Value;

class TableColumn extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.table.column';
    
    public array $header = [];
    
    public array $entry = [];

    public $value = 'id';

    public array $attributes = [];

    public function value()
    {
        return Value::make($this->value, $this->entry);
    }
}
