<?php

namespace Streams\Ui\Panels\Traits;

use Illuminate\Contracts\Support\Htmlable;

trait HasUserAvatar
{
    protected string | Htmlable | \Closure | null $avatar = null;

    public function userAvatar(string | Htmlable | \Closure | null $avatar): static
    {
        $this->userAvatar = $avatar;

        return $this;
    }

    public function getUserAvatar(): string | Htmlable | null
    {
        return $this->evaluate($this->userAvatar);
    }
}
