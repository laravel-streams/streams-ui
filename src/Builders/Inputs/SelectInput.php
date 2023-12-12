<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\Concerns;

class SelectInput extends Input
{
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;

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
