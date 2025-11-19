<?php

namespace Streams\Ui\Builders\Inputs;

class ColorInput extends Input
{
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::builders.inputs.color';
}
