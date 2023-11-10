<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class FileInput extends Input
{
    public function render()
    {
        return view('ui::components.inputs.file');
    }
}
