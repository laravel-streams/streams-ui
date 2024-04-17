<?php

namespace Streams\Ui\Notifications\Traits;

trait HasDuration
{
    protected int | \Closure | null $duration = null;

    public function duration(int | \Closure | null $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDuration(): string | array | null
    {
        return $this->evaluate($this->duration);
    }
}
