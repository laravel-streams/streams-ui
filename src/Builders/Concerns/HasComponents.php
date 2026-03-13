<?php

namespace Streams\Ui\Builders\Concerns;

trait HasComponents
{
    protected array|\Closure $components = [];

    public function bootHasComponents(): void
    {
        foreach ($this->getComponents() as $component) {
            if (method_exists($component, 'boot')) {
                $component->boot();
            }
        }
    }

    public function components(array|\Closure $components): static
    {
        $this->components = $components;

        return $this;
    }

    public function getComponents(): array
    {
        return $this->evaluate($this->components);
    }
}
