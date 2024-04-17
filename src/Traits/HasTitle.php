<?php

namespace Streams\Ui\Traits;

trait HasTitle
{
    protected string | \Closure | null $title = null;

    public function title(string | \Closure | null $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string | null
    {
        return $this->evaluate($this->title);
    }
}
