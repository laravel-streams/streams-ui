<?php

namespace Streams\Ui\Builders\Containers\Concerns;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns\HasComponents;
use Streams\Ui\Builders\Containers\Container;

trait HasContainers
{
    use HasComponents;

    public function getComponentContainers(bool $hidden = false): array
    {
        if (!$this->hasComponentContainer($hidden)) {
            return [];
        }

        return [$this->getComponentContainer()];
    }

    public function getComponentContainer($key = null): ViewBuilder
    {
        if (filled($key)) {
            return $this->getComponentContainers()[$key];
        }

        return app($this->getComponentContainerName())
            ->getParentContainer($this)
            ->components($this->getComponents());
    }

    public function getComponentContainerName(): string
    {
        return Container::class;
    }

    public function hasComponentContainer(bool $hidden = false): bool
    {
        if (!$hidden && $this->isHidden()) {
            return false;
        }

        if (!$this->getComponents()) {
            return false;
        }

        return true;
    }
}
