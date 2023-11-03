<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Illuminate\Support\Str;
use Streams\Ui\Components\Traits\HasAttributes;

class Anchor extends Component
{
    use HasAttributes;

    public ?string $url = null;
    public ?string $text = null;

    public array $htmlAttributes = [];

    public function render()
    {
        return view('ui::components.anchor');
    }
}
