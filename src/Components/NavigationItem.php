<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class NavigationItem extends Component
{
    public ?string $url;
    public ?string $text;
    public ?string $name;
    public ?string $icon = null;
    
    protected string $template = <<<'blade'
        <a href="{{ $url }}">
            {{ $text }}
        </a>
    blade;

    static public function make(array $attributes = []): static
    {
        $instance = new static;

        array_map(function ($value, $key) use ($instance) {
            $instance->{$key} = $value;
        }, $attributes, array_keys($attributes));

        return $instance;
    }
}
