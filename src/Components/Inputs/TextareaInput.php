<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class TextareaInput extends Input
{
    public int $rows = 3;

    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $placeholder = null;

    public function render()
    {
        return view('ui::components.inputs.textarea');
    }
}
