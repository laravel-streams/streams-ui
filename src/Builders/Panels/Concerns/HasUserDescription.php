<?php

namespace Streams\Ui\Builders\Panels\Concerns;

use Illuminate\Contracts\Support\Htmlable;

trait HasUserDescription
{
    protected string|Htmlable|\Closure|null $userDescription = null;

    public function userDescription(string|Htmlable|\Closure|null $description): static
    {
        $this->userDescription = $description;

        return $this;
    }

    public function getUserDescription(): string|Htmlable|null
    {
        return $this->evaluate($this->userDescription);
    }
}
