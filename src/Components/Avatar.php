<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Avatar extends Component
{
    public $classes = [
        'a-avatar',
    ];

    public string $component = 'avatar';
    public string $template = 'ui::components.avatar';    
}
