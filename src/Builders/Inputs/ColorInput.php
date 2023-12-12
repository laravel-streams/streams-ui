<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Concerns;

class ColorInput extends Input
{
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::builders.inputs.color';
}
