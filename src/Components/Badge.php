<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Badge extends Component
{
    public ?string $text = null;

    public function render()
    {
        return view('ui::components.badge');
    }
}
