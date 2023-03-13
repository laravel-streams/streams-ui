<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class ToggleInput extends Input
{
    public string $template = 'ui::components.inputs.toggle';
    
    public ?string $label = null;
}
