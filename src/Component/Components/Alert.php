<?php

namespace Streams\Ui\Component\Components;

use Illuminate\View\Component;
use function view;

class Alert extends Component
{
    public $componentName='alert';

    public function __construct(public string $type)
    {
    }

    public function render()
    {
        return view('ui::components.alert');
    }
}
