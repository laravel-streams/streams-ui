<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class TextInput extends Input
{
    public string $alias = 'input';

    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $pattern = null;

    public string $type = 'text';
    
    public ?string $placeholder = null;
}
