<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class UrlInput extends Input
{
    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $pattern = null;

    public string $type = 'url';
    
    public ?string $placeholder = null;
}
