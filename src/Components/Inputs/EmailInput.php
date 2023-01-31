<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class EmailInput extends Input
{
    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $pattern = null;

    public string $type = 'email';
    
    public ?string $placeholder = null;
}
