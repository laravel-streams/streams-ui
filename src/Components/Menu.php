<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Menu extends Component
{
    use HasAttributes;

    public array $items = [];

    public array $htmlAttributes = [];

    public function render()
    {
        return view('ui::components.menu');
    }
}
