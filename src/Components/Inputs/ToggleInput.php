<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class ToggleInput extends Input
{
    public ?string $label = null;

    public function render()
    {
        return view('ui::components.inputs.toggle');
    }
}
