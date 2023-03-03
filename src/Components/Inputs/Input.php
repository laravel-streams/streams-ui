<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input as AbstractInput;

class Input extends AbstractInput
{
    public string $template = 'ui::components.input';
    
    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $pattern = null;

    public string $type = 'text';
    
    public ?string $placeholder = null;
}
