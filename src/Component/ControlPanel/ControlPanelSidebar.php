<?php

namespace Streams\Ui\Component\ControlPanel;

use Illuminate\View\Component;
use function view;

class ControlPanelSidebar extends Component
{
    public function __construct(public string $brandMode = '')
    {
    }
    public function render()
    {
        return view('ui::components.cp.sidebar');
    }
}
