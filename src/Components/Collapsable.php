<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Collapsable extends Component
{
    use HasAttributes;

    public ?string $text = null;

    public array $components = [];

    public function render()
    {
        return view('ui::components.collapsable');
    }
}
