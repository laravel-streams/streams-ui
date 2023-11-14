<?php

namespace Streams\Ui\Support\Concerns;

trait HasHeading
{
    protected string | \Closure | null $heading = null;

    public function heading(string | \Closure | null $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading(): string | null
    {
        return $this->evaluate($this->heading);
    }
}
