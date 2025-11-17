<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Traits;

class ColorInput extends Input
{
    use Traits\HasPlaceholder;

    protected string $view = 'ui::builders.inputs.color';
}
