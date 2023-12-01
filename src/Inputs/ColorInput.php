<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Concerns;

class ColorInput extends Input
{
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::components.inputs.color';
}
