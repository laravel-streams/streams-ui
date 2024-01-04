<?php

namespace Streams\Ui\Panels\Traits;

trait HasResources
{
    protected array $resources = [];

    public function resources(array $resources): static
    {
        $this->resources = [
            ...$this->resources,
            ...$resources,
        ];

        return $this;
    }

    public function getResources(): array
    {
        return array_unique($this->resources);
    }
}
