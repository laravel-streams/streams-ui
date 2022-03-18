<?php

namespace Streams\Ui\Component\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ButtonBladeComponent extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return View::make('ui::components.button');
    }
}
