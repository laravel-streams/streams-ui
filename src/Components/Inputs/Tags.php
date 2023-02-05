<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Tags extends Input
{
    public string $template = 'ui::components.inputs.tags';

    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $placeholder = null;
}
