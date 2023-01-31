<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class NumberInput extends Input
{
    public string $template = 'ui::components.inputs.number';
    
    public float $step = 1;
    
    public ?float $min = null;
    public ?float $max = null;
    
    public ?string $pattern = null;

    public string $type = 'number';
    
    public ?string $placeholder = null;
}
