<?php

namespace Streams\Ui\Builders\Actions\Concerns;

trait HasTag
{
    protected string | \Closure | null $tag = null;

    public function tag(string | \Closure | null $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTag(): string | null
    {
        return $this->evaluate($this->tag);
    }
}
