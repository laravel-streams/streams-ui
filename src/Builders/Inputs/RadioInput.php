<?php

namespace Streams\Ui\Builders\Inputs;

class RadioInput extends Input
{
    use Traits\HasOptions;
    use Traits\HasPlaceholder;

    protected string $view = 'ui::components.inputs.radio';
}
