<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Navigation extends Component
{
    use HasAttributes;

    public string $activeItemClass = 'active-item';

    public array $items = [];

    public array $htmlAttributes = [];

    public function render()
    {
        return view('ui::components.navigation');
    }
}
