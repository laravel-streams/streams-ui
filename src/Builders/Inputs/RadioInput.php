<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\Concerns;

class RadioInput extends Input
{
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::components.inputs.radio';
}
