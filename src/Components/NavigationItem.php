<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class NavigationItem extends Component
{
    public ?string $url;
    public ?string $text;
    public ?string $name;
    
    protected string $template = <<<'blade'
        <a href="{{ $url }}">
            {{ $text }}
        </a>
    blade;
}
