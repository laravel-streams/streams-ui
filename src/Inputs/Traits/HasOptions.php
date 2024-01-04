<?php

namespace Streams\Ui\Inputs\Traits;

trait HasOptions
{
    protected array | \Closure | null $options = null;

    public function options(array | \Closure | null $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(): ?array
    {
        $options = $this->evaluate($this->options);

        return $options;
    }
}
