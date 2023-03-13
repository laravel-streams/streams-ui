<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Drawer extends Component
{
    public string $template = 'ui::components.drawer';

    public array $components = [];
    
    public bool $open = false;
 
    protected $listeners = [
        'showDrawer' => 'show',
        'hideDrawer' => 'hide',
    ];
 
    public function show()
    {
        $this->open = true;
    }

    public function hide()
    {
        $this->open = false;
    }
}
