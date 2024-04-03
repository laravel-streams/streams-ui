<?php

namespace Streams\Ui\Traits;

use Illuminate\Support\Arr;

trait HasState
{
    protected mixed $defaultState = null;

    protected ?string $statePath = null;
    protected ?string $statePathCache = null;

    public function default(mixed $state): static
    {
        $this->defaultState = $state;

        return $this;
    }

    public function fill(array $data = []): void
    {
        $state = [];

        $statePath = $this->getStatePath(true);

        Arr::set($state, $statePath, $data);

        $this->hydrateState($data);

        $livewire = $this->getLivewire();

        if ($statePath) {
            data_set($livewire, $statePath, $data);
        } else {
            foreach ($data as $key => $value) {
                data_set($livewire, $key, $value);
            }
        }
    }

    public function dehydrateState(array &$state): void
    {
        if (!$this->isDehydrated()) {
            if ($this->statePath) {
                Arr::forget($state, $this->getStatePath());
            }

            return;
        }

        if ($this->getStatePath(absolute: false)) {
            foreach ($this->getStateToDehydrate() as $key => $value) {
                Arr::set($state, $key, $value);
            }
        }

        foreach ($this->getComponentContainers() as $container) {

            if ($container->isHidden()) {
                continue;
            }

            $container->dehydrateState($state);
        }
    }

    public function dehydrateStateUsing(?\Closure $callback): static
    {
        $this->dehydrateStateUsing = $callback;

        return $this;
    }

    public function hydrateState(?array &$state): void
    {
        $this->hydrateDefaultState($state);

        foreach ($this->getComponents() as $container) {
            $container->parent($this);
            $container->hydrateState($state);
        }

        // $this->callAfterStateHydrated();
    }

    // public function fill(): void
    // {
    //     $defaults = [];

    //     $this->hydrateDefaultState($defaults);
    // }

    public function hydrateDefaultState(?array &$state): void
    {
        // @todo this should never happen - remove
        // if ($state === null) {

        //     $state = $this->getState();

        //     // Hydrate all arrayable state objects as arrays by converting
        //     // them to collections, then using `toArray()`.
        //     if (is_array($state)) {
        //         $this->state(collect($state)->toArray());
        //     }

        //     return;
        // }

        $statePath = $this->getStatePath();

        if (Arr::has($state, $statePath)) {
            return;
        }

        if (!$this->hasDefaultState()) {

            $this->state(null);

            return;
        }

        $defaultState = $this->getDefaultState();

        $this->state($defaultState);

        Arr::set($state, $statePath, $defaultState);
    }

    public function fillStateWithNull(): void
    {
        // if (!Arr::has((array) $this->getLivewire(), $this->getStatePath())) {
        //     $this->state(null);
        // }

        // foreach ($this->getComponentContainers(true) as $container) {
        //     $container->fillStateWithNull();
        // }
    }

    public function state(mixed $state): static
    {
        $livewire = $this->getLivewire();

        data_set($livewire, $this->getStatePath(), $this->evaluate($state));

        return $this;
    }

    public function statePath(?string $path): static
    {
        $this->statePath = $path;

        return $this;
    }

    public function getDefaultState(): mixed
    {
        return $this->evaluate($this->defaultState);
    }

    public function getState(): mixed
    {
        $state = data_get($this->getLivewire(), $this->getStatePath());

        if (is_array($state)) {
            return $state;
        }

        if (blank($state)) {
            return null;
        }

        return $state;
    }

    // public function getOldState(): mixed
    // {
    //     if (!Livewire::isLivewireRequest()) {
    //         return null;
    //     }

    //     $state = $this->getLivewire()->getOldFormState($this->getStatePath());

    //     if (blank($state)) {
    //         return null;
    //     }

    //     return $state;
    // }

    public function getStatePath(bool $absolute = true): string
    {
        if ($this->statePathCache) {
            return $this->statePathCache;
        }

        if (!$absolute) {
            return $this->statePath ?? '';
        }

        $parts = [];

        if ($parentStatePath = $this->getParent()?->getStatePath()) {
            $parts[] = $parentStatePath;
        }

        if ($this->statePath) {
            $parts[] = $this->statePath;
        }

        return $this->statePathCache = implode('.', $parts);
    }

    public function hasStatePath(): bool
    {
        return $this->statePath !== null;
    }

    protected function hasDefaultState(): bool
    {
        return $this->defaultState !== null;
    }
}
