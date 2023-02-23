<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Modal extends Component
{
    public string $template = 'ui::components.modal';

    public array $content = [];
    
    public bool $open = false;
 
    protected $listeners = [
        'showModal' => 'show',
        'hideModal' => 'hide',
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
