<?php

namespace Streams\Ui\Actions\Traits;

trait HasTag
{
    protected string | \Closure | null $tag = 'button';

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
