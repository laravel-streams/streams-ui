<?php

namespace Streams\Ui\Components\Inputs;

class SlugInput extends BasicInput
{
    public string $separator = '-';

    public function render()
    {
        return view('ui::components.inputs.slug');
    }
}
