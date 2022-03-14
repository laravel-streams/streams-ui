<?php

namespace Streams\Ui\Component\ControlPanel;

use Illuminate\View\Component;
use function view;

class ControlPanelHeader extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return view('ui::components.cp.header');
    }
}
