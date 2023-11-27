<?php

namespace Streams\Ui\Forms\Concerns;

trait HasComponents
{
    protected array | \Closure $components = [];

    public function components(array | \Closure $components): static
    {
        $this->components = $components;

        return $this;
    }

    public function getComponents(): array
    {
        return $this->evaluate($this->components);
    }

    // public function getComponentContainer($key = null): ComponentContainer
    // {
    //     if (filled($key)) {
    //         return $this->getComponentContainers()[$key];
    //     }

    //     return ComponentContainer::make($this->getLivewire())
    //         ->parentComponent($this)
    //         ->components($this->getComponents());
    // }

    // public function getComponentContainers(bool $withHidden = false): array
    // {
    //     if (! $this->hasComponentContainer($withHidden)) {
    //         return [];
    //     }

    //     return [$this->getComponentContainer()];
    // }

    // public function hasComponentContainer(bool $withHidden = false): bool
    // {
    //     if ((! $withHidden) && $this->isHidden()) {
    //         return false;
    //     }

    //     if ($this->getComponents() === []) {
    //         return false;
    //     }

    //     return true;
    // }
}
