<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Ui\Support\Facades\Breadcrumbs as Collection;

class Breadcrumbs extends Component
{
    public array $items = [];
    
    public function render()
    {
        return view('ui::components.breadcrumbs', [
            //'items' => Collection::all(),
        ]);
    }
}
