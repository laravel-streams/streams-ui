<?php

namespace Streams\Ui\Panels\Traits;

use Illuminate\Contracts\Support\Htmlable;

trait HasBrandLogo
{
    protected string | Htmlable | \Closure | null $brandLogo = null;

    public function brandLogo(string | Htmlable | \Closure | null $logo): static
    {
        $this->brandLogo = $logo;

        return $this;
    }

    public function getBrandLogo(): string | Htmlable
    {
        return $this->evaluate($this->brandLogo);
    }
}
