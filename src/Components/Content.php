<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Content extends Component
{
    use HasAttributes;

    public ?string $content = null;

    public array $htmlAttributes = [];

    public function render()
    {
        return view('ui::components.content');
    }
}
