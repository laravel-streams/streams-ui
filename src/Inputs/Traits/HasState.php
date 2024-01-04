<?php

namespace Streams\Ui\Inputs\Traits;

use Illuminate\Support\Arr;
use Livewire\Livewire;

use function Livewire\store;

trait HasState
{
    protected mixed $defaultState = null;

    protected bool | \Closure $isDehydrated = true;

    protected ?string $statePath = null;

    public function default(mixed $state): static
    {
        $this->defaultState = $state;
        $this->hasDefaultState = true;

        return $this;
    }

    public function dehydrated(bool | \Closure $condition = true): static
    {
        $this->isDehydrated = $condition;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $state
     */
    public function dehydrateState(array &$state): void
    {
        if (!$this->isDehydrated()) {
            if ($this->hasStatePath()) {
                Arr::forget($state, $this->getStatePath());
            }

            return;
        }

        if ($this->getStatePath(isAbsolute: false)) {
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

    /**
     * @param  array<string, mixed> | null  $hydratedDefaultState
     */
    public function hydrateState(?array &$hydratedDefaultState): void
    {
        $this->hydrateDefaultState($hydratedDefaultState);

        // foreach ($this->getComponentContainers(true) as $container) {
        //     $container->hydrateState($hydratedDefaultState);
        // }

        $this->callAfterStateHydrated();
    }

    public function fill(): void
    {
        $defaults = [];

        $this->hydrateDefaultState($defaults);
    }

    /**
     * @param  array<string, mixed> | null  $hydratedDefaultState
     */
    public function hydrateDefaultState(?array &$hydratedDefaultState): void
    {
        if ($hydratedDefaultState === null) {

            //$this->loadStateFromRelationships();

            $state = $this->getState();

            // Hydrate all arrayable state objects as arrays by converting
            // them to collections, then using `toArray()`.
            if (is_array($state)) {
                $this->state(collect($state)->toArray());
            }

            return;
        }

        $statePath = $this->getStatePath();

        if (Arr::has($hydratedDefaultState, $statePath)) {
            return;
        }

        if (!$this->hasDefaultState()) {
            
            $this->state(null);

            return;
        }

        $defaultState = $this->getDefaultState();

        $this->state($this->getDefaultState());

        Arr::set($hydratedDefaultState, $statePath, $defaultState);
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

    public function mutateDehydratedState(mixed $state): mixed
    {
        return $this->evaluate(
            $this->mutateDehydratedStateUsing,
            ['state' => $state],
        );
    }

    public function mutatesDehydratedState(): bool
    {
        return $this->mutateDehydratedStateUsing instanceof \Closure;
    }

    public function mutateDehydratedStateUsing(?\Closure $callback): static
    {
        $this->mutateDehydratedStateUsing = $callback;

        return $this;
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
        // $state = data_get($this->getLivewire(), $this->getStatePath());
        $state = __METHOD__;

        if (is_array($state)) {
            return $state;
        }

        if (blank($state)) {
            return null;
        }

        return $state;
    }

    public function getOldState(): mixed
    {
        if (!Livewire::isLivewireRequest()) {
            return null;
        }

        $state = $this->getLivewire()->getOldFormState($this->getStatePath());

        if (blank($state)) {
            return null;
        }

        return $state;
    }

    public function getStatePath(bool $isAbsolute = true): string
    {
        if (!$isAbsolute) {
            return $this->statePath ?? '';
        }

        if (isset($this->cachedAbsoluteStatePath)) {
            return $this->cachedAbsoluteStatePath;
        }

        $pathComponents = [];

        // if ($containerStatePath = $this->getContainer()->getStatePath()) {
        //     $pathComponents[] = $containerStatePath;
        // }

        if ($this->hasStatePath()) {
            $pathComponents[] = $this->statePath;
        }

        return $this->cachedAbsoluteStatePath = implode('.', $pathComponents);
    }

    public function hasStatePath(): bool
    {
        return filled($this->statePath);
    }

    protected function hasDefaultState(): bool
    {
        return $this->hasDefaultState;
    }

    public function isDehydrated(): bool
    {
        return (bool) $this->evaluate($this->isDehydrated);
    }
}
