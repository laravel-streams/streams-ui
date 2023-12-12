<?php

namespace Streams\Ui\Builders\Concerns;

trait HasUrl
{
    protected string | \Closure | null $url = null;

    protected bool | \Closure $openInNewTab = false;

    public function url(
        string | \Closure | null $url,
        bool | \Closure $openInNewTab = false
    ): static {
        
        $this->openInNewTab($openInNewTab);

        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->evaluate($this->url);
    }

    public function openInNewTab(bool | \Closure $condition = true): static
    {
        $this->openInNewTab = $condition;

        return $this;
    }

    public function shouldOpenInNewTab(): bool
    {
        return (bool) $this->evaluate($this->openInNewTab);
    }
}
