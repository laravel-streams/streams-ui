<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Image extends File
{
    public string $template = 'ui::components.input.image';
    
    public array $accept = [
        'image/png',
        'image/jpg',
        'image/jpeg',
    ];
}
