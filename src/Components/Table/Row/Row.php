<?php

namespace Streams\Ui\Components\Table\Row;

use Streams\Ui\Support\Component;

class Row extends Component
{
    public ?string $key = null;
    
    //public ?object $entry = null;

    public $columns = [];
    public $buttons = [];
}
