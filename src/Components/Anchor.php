<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Anchor extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.anchor';

    public ?string $url = null;
    public ?string $text = null;

    public array $attributes = [];

    public function url()
    {
        return $this->url ? Str::parse($this->url) : null;
    }
}
