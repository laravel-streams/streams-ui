<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Input;
use Streams\Ui\Inputs\Traits;

class SelectInput extends Input
{
    use Traits\HasOptions;
    use Traits\HasPlaceholder;

    protected string $view = 'ui::components.inputs.select';

    protected bool | \Closure $multiple = false;

    public function multiple(bool | \Closure $condition = true): static
    {
        $this->multiple = $condition;

        return $this;
    }

    public function isMultiple(): bool
    {
        return (bool) $this->evaluate($this->multiple);
    }
}
