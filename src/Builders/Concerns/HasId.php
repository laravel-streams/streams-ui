<?php

namespace Streams\Ui\Builders\Concerns;

trait HasId
{
    protected string | \Closure | null $id = null;

    public function id(string | \Closure | null $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->evaluate($this->id);
    }
}
