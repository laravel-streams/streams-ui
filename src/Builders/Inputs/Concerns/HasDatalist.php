<?php

namespace Streams\Ui\Builders\Inputs\Concerns;

trait HasDatalist
{
    protected array | \Closure | null $datalist = null;

    public function datalist(array | \Closure | null $options): static
    {
        $this->datalist = $options;

        return $this;
    }

    public function getDatalist(): ?array
    {
        $options = $this->evaluate($this->datalist);

        return $options;
    }
}
