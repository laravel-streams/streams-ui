<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Dropdown extends Component
{
    public array $toggle = [];
    
    public array $components = [];

    public function render()
    {
        return view('ui::components.dropdown');
    }
}
