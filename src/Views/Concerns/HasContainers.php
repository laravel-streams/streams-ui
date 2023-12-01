<?php

namespace Streams\Ui\Views\Concerns;

use Streams\Ui\Support\Concerns\HasComponents;
use Streams\Ui\Views\ViewContainer;

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

    public function getComponentContainer($key = null): ViewContainer
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
        return ViewContainer::class;
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
