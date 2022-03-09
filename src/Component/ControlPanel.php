<?php

namespace Streams\Ui\Component;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class ControlPanel extends Component
{
    public function __construct(public string $brandMode = '')
    {
    }
    public function render()
    {
        return view('ui::components.cp');
    }
}
