<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Tabs extends Component
{
    use HasAttributes;

    public array $tabs = [];

    public array $htmlAttributes = [];

    public function render()
    {
        return view('ui::components.tabs');
    }
}
