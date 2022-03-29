<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Avatar extends Component
{
    public array $classes = [
        'a-avatar',
    ];

    public array $attributes = [
        'style' => 'margin: 1rem;',
    ];

    public string $component = 'avatar';
    public string $template = 'ui::components.avatar';    
}
