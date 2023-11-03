<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Drawer extends Component
{
    public array $components = [];
    
    public bool $open = false;
 
    protected $listeners = [
        'showDrawer' => 'show',
        'hideDrawer' => 'hide',
    ];

    public function render()
    {
        return view('ui::components.drawer');
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
