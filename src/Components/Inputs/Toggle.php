<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Toggle extends Input
{
    public string $template = 'ui::components.inputs.toggle';
    
    public string $type = 'checkbox';
    
    public $classes = [
        'c-input',
        '-toggle-input',
    ];
}
