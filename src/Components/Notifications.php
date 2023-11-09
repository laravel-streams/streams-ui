<?php

namespace Streams\Ui\Components;

use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        return view('ui::components.notifications', [
            'notifications' => [],
        ]);
    }
}
