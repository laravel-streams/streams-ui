<?php

namespace Streams\Ui\Component\Components;

use Illuminate\View\Component;
use function view;

class Toolbar extends Component
{
    public $componentName = 'toolbar';

    public function __construct(public string $type)
    {
    }

    public function render()
    {
        return view('ui::components.toolbar');
    }
}
