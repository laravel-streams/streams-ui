<?php

namespace Streams\Ui\Builders\Panels\Concerns;

trait HasTenant
{
    protected $tenant = null;

    protected $cachedTenant = null;

    public function tenant($tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getTenant(): mixed
    {
        return $this->cachedTenant ?: $this->cachedTenant = $this->evaluate($this->tenant);
    }
}
