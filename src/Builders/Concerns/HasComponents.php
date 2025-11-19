<?php

namespace Streams\Ui\Builders\Concerns;

trait HasComponents
{
    protected array|\Closure $components = [];

    public function components(array|\Closure $components): static
    {
        $this->components = $components;

        return $this;
    }

    public function getComponents(): array
    {
        return $this->evaluate($this->components);
    }

    /**
     * This ensures that mountable actions defined
     * within components are accessible from the parent.
     */
    public function getComponentMountableActions(): array
    {
        $actions = [];

        foreach ($this->getComponents() as $component) {
            if (method_exists($component, 'getMountableActions')) {
                $actions = array_merge($actions, $component->getMountableActions());
            }
        }

        return $actions;
    }
}
