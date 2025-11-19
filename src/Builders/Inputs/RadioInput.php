<?php

namespace Streams\Ui\Builders\Inputs;

class RadioInput extends Input
{
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::components.inputs.radio';
}
