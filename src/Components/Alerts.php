<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Alerts extends Component
{
    public function render()
    {
        return view('ui::components.alerts', [
            'alerts' => [],
        ]);
    }
}
