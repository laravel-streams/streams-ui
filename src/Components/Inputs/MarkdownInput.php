<?php

namespace Streams\Ui\Components\Inputs;

class MarkdownInput extends TextareaInput
{
    public function render()
    {
        return view('ui::components.inputs.markdown');
    }
}
