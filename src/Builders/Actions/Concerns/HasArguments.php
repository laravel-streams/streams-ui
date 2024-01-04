<?php

namespace Streams\Ui\Builders\Actions\Concerns;

trait HasArguments
{
    protected array $arguments = [];

    public function arguments(array $arguments): static
    {
        $this->arguments = $arguments;

        return $this;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function resetArguments(): static
    {
        $this->arguments([]);

        return $this;
    }
}
