<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class IntegerInput extends Input
{
    public ?int $step = null;
    
    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $pattern = null;

    public string $type = 'number';
    
    public ?string $placeholder = null;
}
