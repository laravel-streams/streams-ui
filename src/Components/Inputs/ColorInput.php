<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class ColorInput extends Input
{
    public string $template = 'ui::components.inputs.color';
    
    public ?string $pattern = null;
}
