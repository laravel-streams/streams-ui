<?php

namespace Streams\Ui\Panels\Traits;

trait HasTenant
{
    protected $tenant = null;

    public function tenant($tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getTenant(): mixed
    {
        return $this->evaluate($this->tenant);
    }
}
