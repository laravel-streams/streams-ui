<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class RangeInput extends Input
{
    public string $type = 'range';
    
    public ?float $min = null;
    public ?float $max = null;
    
    public float $step = 1;

    public function render()
    {
        return view('ui::components.inputs.range');
    }
}
