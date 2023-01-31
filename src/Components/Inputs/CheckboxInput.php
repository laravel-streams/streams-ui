<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class CheckboxInput extends Input
{
    public string $template = 'ui::components.inputs.checkbox';
    
    public ?string $label = null;
}
