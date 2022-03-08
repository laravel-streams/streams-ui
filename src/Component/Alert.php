<?php

namespace Streams\Ui\Component;

use Illuminate\View\Component;

class Alert extends Component
{

    public function __construct(public string $type)
    {
    }

    public function render()
    {
        return view('ui::components.alert');
    }
}
