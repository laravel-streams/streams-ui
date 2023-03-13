<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Content extends Component
{
    use HasAttributes;

    public string $template = <<<'blade'
        <div>
            {!! $component->decoratePrototypeAttribute('content')->render() !!}
        </div>
    blade;

    public ?string $content = null;

    public array $attributes = [];

    public function url()
    {
        return $this->url ? Str::parse($this->url) : null;
    }
}
