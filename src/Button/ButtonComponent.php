<?php

namespace Streams\Ui\Component\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ButtonComponent extends Component
{
    public $componentName = 'button';

    public function __construct(public string $type)
    {
    }

    public function render()
    {
        return View::make('ui::components.button');
    }
}
