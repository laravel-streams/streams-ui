<?php

namespace Streams\Ui\Builders\Inputs\Concerns;

trait CanBeAutocompleted
{
    protected bool | string | \Closure | null $autocomplete = null;

    public function autocomplete(bool | string | \Closure $condition = true): static
    {
        $this->autocomplete = $condition;

        return $this;
    }

    public function getAutocomplete(): ?string
    {
        return match ($autocomplete = $this->evaluate($this->autocomplete)) {
            true => 'on',
            false => 'off',
            default => $autocomplete,
        };
    }
}
