<?php

namespace Streams\Ui\Builders\Concerns;

trait HasText
{
    protected string|\Closure|null $text = null;

    public function text(string|\Closure|null $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->evaluate($this->text);
    }
}
