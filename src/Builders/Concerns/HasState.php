<?php

namespace Streams\Ui\Builders\Concerns;

use Illuminate\Support\Str;

trait HasState
{
    protected ?string $statePath = null;

    /**
     * When set (typically by {@see \Streams\Ui\Builders\Forms\Form} for inputs), {@see getStatePath()} becomes
     * `{prefix}.{relative}` where relative comes from {@see getDefaultStatePath()} instead of defaulting to `data.{relative}`.
     */
    protected ?string $statePathPrefix = null;

    protected string $cachedFullStatePath;

    public function callAfterStateHydrated(): void
    {
        foreach ($this->getComponents(true) as $component) {

            $component->callAfterStateHydrated();

            foreach ($component->getComponentContainers(true) as $container) {
                $container->callAfterStateHydrated();
            }
        }
    }

    public function callAfterStateUpdated(string $path): bool
    {
        foreach ($this->getComponents(true) as $component) {

            if ($component->getStatePath() === $path) {

                $component->callAfterStateUpdated();

                return true;
            }

            if (str($path)->startsWith("{$component->getStatePath()}.")) {
                $component->callAfterStateUpdated();
            }

            foreach ($component->getComponentContainers() as $container) {
                if ($container->callAfterStateUpdated($path)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function callBeforeStateDehydrated(): void
    {
        foreach ($this->getComponents(true) as $component) {

            if ($component->isHidden()) {
                continue;
            }

            $component->callBeforeStateDehydrated();

            foreach ($component->getComponentContainers() as $container) {

                if ($container->isHidden()) {
                    continue;
                }

                $container->callBeforeStateDehydrated();
            }
        }
    }

    public function dehydrateState(array &$state = []): array
    {
        foreach ($this->getComponents() as $component) {

            if ($component->isHidden()) {
                continue;
            }

            $component->dehydrateState($state);
        }

        return $state;
    }

    public function mutateDehydratedState(array &$state = []): array
    {
        foreach ($this->getComponents() as $component) {

            if ($component->isHidden()) {
                continue;
            }

            if (! $component->isDehydrated()) {
                continue;
            }

            foreach ($component->getComponentContainers() as $container) {

                if ($container->isHidden()) {
                    continue;
                }

                $container->mutateDehydratedState($state);
            }

            if ($component->getStatePath(isAbsolute: false)) {

                if (! $component->mutatesDehydratedState()) {
                    continue;
                }

                $componentStatePath = $component->getStatePath();

                data_set(
                    $state,
                    $componentStatePath,
                    $component->mutateDehydratedState(
                        data_get($state, $componentStatePath),
                    ),
                );
            }
        }

        return $state;
    }

    /**
     * Hydrate Livewire state for this builder’s {@see getStatePath()} (for example the form’s `data.{form-name}` bucket).
     *
     * On {@see Form}, call after {@see Form::resolve()} so the instance is bound to the host component:
     * `$form->fill([ 'field' => $value, ... ])`.
     *
     * Passing a non-null array replaces the entire subtree at that path. Pass `[]` to clear the form bucket.
     */
    public function fill(?array $state = null): static
    {
        if ($state === null) {
            return $this;
        }

        $livewire = $this->getLivewire();

        if ($this->getStatePath()) {
            data_set($livewire, $this->getStatePath(), $state);
        } else {
            foreach ($state as $key => $value) {
                data_set($livewire, $key, $value);
            }
        }

        return $this;
    }

    public function hydrateState(?array &$hydratedDefaultState): void
    {
        foreach ($this->getComponents(true) as $component) {
            $component->hydrateState($hydratedDefaultState);
        }
    }

    public function fillStateWithNull(): void
    {
        foreach ($this->getComponents(true) as $component) {
            $component->fillStateWithNull();
        }
    }

    public function statePath(?string $path): static
    {
        $this->statePath = $path;

        if ($path !== null) {
            $this->statePathPrefix = null;
        }

        $this->flushCachedStatePath();

        return $this;
    }

    /**
     * Base Livewire path under which this component’s state is stored (before the relative segment from {@see getDefaultStatePath()}).
     *
     * Forms pass their resolved {@see getStatePath()} so fields resolve to `{form path}.{field name}` instead of `data.{field name}`.
     */
    public function statePathPrefix(?string $prefix): static
    {
        $this->statePathPrefix = $prefix;
        $this->flushCachedStatePath();

        return $this;
    }

    /**
     * Validated form/component state (runs field validation rules).
     *
     * Prefer this when reading user input for persistence or DTO mapping — same path submit handlers use.
     */
    public function getState(bool $shouldCallHooksBefore = true): array
    {
        $state = $this->validate();

        // $this->dehydrateState($state);
        // $this->mutateDehydratedState($state);

        if ($statePath = $this->getStatePath()) {
            return data_get($state, $statePath) ?? [];
        }

        return $state;
    }

    /**
     * Livewire-bound values at {@see getStatePath()} without validation.
     *
     * Use only when validation must not run (for example inspecting UI state before submit, merge helpers, or
     * debugging). For submit workflows and DTO input, use {@see getState()} instead.
     */
    public function getRawState(): array
    {
        return data_get($this->getLivewire(), $this->getStatePath()) ?? [];
    }

    public function getStatePath(): string
    {
        if (isset($this->cachedFullStatePath)) {
            return $this->cachedFullStatePath;
        }

        if (($statePath = $this->statePath) !== null) {
            return $this->cachedFullStatePath = $statePath;
        }

        if (($prefix = $this->statePathPrefix) !== null) {
            return $this->cachedFullStatePath = $prefix.'.'.$this->getDefaultStatePath();
        }

        return $this->cachedFullStatePath = implode('.', [
            'data',
            $this->getDefaultStatePath(),
        ]);
    }

    protected function getDefaultStatePath(): string
    {
        if (method_exists($this, 'getName')) {
            return $this->getName();
        }

        $parts = explode('\\', static::class);

        return Str::kebab(end($parts));
    }

    protected function flushCachedStatePath(): void
    {
        unset($this->cachedFullStatePath);
    }
}
