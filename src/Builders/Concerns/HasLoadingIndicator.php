<?php

namespace Streams\Ui\Builders\Concerns;

trait HasLoadingIndicator
{
    protected string|bool|\Closure|null $loadingIndicator = null;

    protected string|bool|\Closure|null $loadingText = null;

    public function loadingIndicator(string|bool|\Closure|null $loadingIndicator = true): static
    {
        $this->loadingIndicator = $loadingIndicator;

        return $this;
    }

    public function getLoadingIndicator(): bool|string|null
    {
        return $this->evaluate($this->loadingIndicator);
    }

    public function loadingText(string|bool|\Closure|null $loadingText = null): static
    {
        $this->loadingText = $loadingText;

        return $this;
    }

    public function getLoadingText(): bool|string|null
    {
        return $this->evaluate($this->loadingText);
    }
}
