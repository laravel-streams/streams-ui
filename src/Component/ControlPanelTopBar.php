<?php

namespace Streams\Ui\Component;

use Illuminate\View\Component;

class ControlPanelTopBar extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return view('ui::components.cp-top-bar');
    }
}
