<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Modal extends Component
{
    public array $components = [];
    
    public bool $open = false;
 
    protected $listeners = [
        'showModal' => 'show',
        'hideModal' => 'hide',
    ];
    public function render()
    {
        return view('ui::components.modal');
    }
 
    public function show()
    {
        $this->open = true;
    }

    public function hide()
    {
        $this->open = false;
    }
}
