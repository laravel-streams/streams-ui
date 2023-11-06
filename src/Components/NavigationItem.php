<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class NavigationItem extends Component
{
    public string $url;
    public string $label;
    
    protected string $template = <<<'blade'
        <a href="{{ $url }}">
            {{ $label }}
        </a>
    blade;
}
