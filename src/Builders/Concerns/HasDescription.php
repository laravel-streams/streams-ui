<?php

namespace Streams\Ui\Builders\Concerns;

trait HasDescription
{
    protected string | \Closure | null $description = null;

    public function description(string | \Closure | null $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string | null
    {
        return $this->evaluate($this->description);
    }
}
