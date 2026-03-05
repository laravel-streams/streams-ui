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

    // @todo not working.. we need to refresh tables.
    public function refreshTables(array $components = []): void
    {
        $components = $components ?: $this->getComponents();
        
        foreach ($components as $component) {

            if (method_exists($component, 'bootedInteractsWithTable')) {
                $component->bootedInteractsWithTable();
            }

            // if (method_exists($component, 'getLivewireComponent')) {
            //     $component = app($component->getLivewireComponent());
            // }

            if (method_exists($component, 'refreshTables')) {
                $component->refreshTables();
            }

            if (method_exists($component, 'getComponents')) {
                $this->refreshTables($component->getComponents());
            }
        }
    }
}
