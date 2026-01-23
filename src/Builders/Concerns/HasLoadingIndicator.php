<?php

namespace Streams\Ui\Builders\Concerns;

trait HasLoadingIndicator
{
    protected string|bool|\Closure|null $loadingIndicator = null;

    public function loadingIndicator(string|bool|\Closure|null $loadingIndicator = true): static
    {
        $this->loadingIndicator = $loadingIndicator;

        return $this;
    }

    public function getLoadingIndicator(): bool|string|null
    {
        return $this->evaluate($this->loadingIndicator);
    }
}
