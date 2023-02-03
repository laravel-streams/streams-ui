<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Textarea extends Input
{
    public string $template = 'ui::components.inputs.textarea';

    public int $rows = 3;

    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $placeholder = null;
}
