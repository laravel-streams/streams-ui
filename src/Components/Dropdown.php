<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Dropdown extends Component
{
    public array $toggle = [];
    
    public array $content = [];

    public function render()
    {
        return view('ui::components.dropdown');
    }
}
