<?php

namespace Streams\Ui\Traits;

trait HasName
{
    protected string | array | \Closure | null $name = null;

    public function name(string | array | \Closure | null $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string | array | null
    {
        return $this->evaluate($this->name);
    }
}
