<?php

namespace Streams\Ui\Panels\Traits;

use Illuminate\Contracts\Support\Htmlable;

trait HasUserName
{
    protected string | Htmlable | \Closure | null $name = null;

    public function userName(string | Htmlable | \Closure | null $name): static
    {
        $this->userName = $name;

        return $this;
    }

    public function getUserName(): string | Htmlable | null
    {
        return $this->evaluate($this->userName);
    }
}
