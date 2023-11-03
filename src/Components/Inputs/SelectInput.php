<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class SelectInput extends Input
{
    public array $options = [];

    public ?string $placeholder = null;

    public function render()
    {
        return view('ui::components.inputs.select');
    }

    public function options(): array
    {
        return (array) ($this->options ?: $this->field?->options());
    }
}
