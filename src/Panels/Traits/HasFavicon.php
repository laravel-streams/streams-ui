<?php

namespace Streams\Ui\Panels\Traits;

use Illuminate\Contracts\Support\Htmlable;

trait HasFavicon
{
    protected string | Htmlable | \Closure | null $favicon = null;

    public function favicon(string | Htmlable | \Closure | null $favicon): static
    {
        $this->favicon = $favicon;

        return $this;
    }

    public function getFavicon(): string | Htmlable | null
    {
        return $this->evaluate($this->favicon);
    }
}
