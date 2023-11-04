<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Indicator extends Component
{
    public ?string $text = null;

    public function render()
    {
        return view('ui::components.indicator');
    }
}
