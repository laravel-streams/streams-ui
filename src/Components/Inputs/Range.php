<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Range extends Input
{
    public string $template = 'ui::components.inputs.range';

    public string $type = 'range';
    
    public ?float $min = null;
    public ?float $max = null;
    
    public float $step = 1;
}
