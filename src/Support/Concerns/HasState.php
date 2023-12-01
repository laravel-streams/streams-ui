<?php

namespace Streams\Ui\Support\Concerns;

trait HasState
{
    protected ?string $statePath = null;

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

            if (!$component->isDehydrated()) {
                continue;
            }

            foreach ($component->getComponentContainers() as $container) {

                if ($container->isHidden()) {
                    continue;
                }

                $container->mutateDehydratedState($state);
            }

            if ($component->getStatePath(isAbsolute: false)) {

                if (!$component->mutatesDehydratedState()) {
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

    public function fill(?array $state = null): static
    {
        $defaultState = null;

        if ($state === null) {
            $defaultState = [];
        } else {

            $livewire = $this->getLivewire();

            if ($statePath = $this->getStatePath()) {
                data_set($livewire, $statePath, $state);
            } else {
                foreach ($state as $key => $value) {
                    data_set($livewire, $key, $value);
                }
            }
        }

        $this->hydrateState($defaultState);

        $this->fillStateWithNull();

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

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getState(bool $shouldCallHooksBefore = true): array
    {
        $state = $this->validate();

        if ($shouldCallHooksBefore) {
            $this->callBeforeStateDehydrated();
            $this->saveRelationships();
            $this->loadStateFromRelationships(andHydrate: true);
        }

        $this->dehydrateState($state);
        $this->mutateDehydratedState($state);

        if ($statePath = $this->getStatePath()) {
            return data_get($state, $statePath) ?? [];
        }

        return $state;
    }

    public function getRawState(): array
    {
        return data_get($this->getLivewire(), $this->getStatePath()) ?? [];
    }

    public function getStatePath(bool $isAbsolute = true): string
    {
        if (isset($this->cachedFullStatePath)) {
            return $this->cachedFullStatePath;
        }

        $pathComponents = [];

        // if ($isAbsolute && $parentComponentStatePath = $this->getParentComponent()?->getStatePath()) {
        //     $pathComponents[] = $parentComponentStatePath;
        // }

        if (($statePath = $this->statePath) !== null) {
            $pathComponents[] = $statePath;
        }

        return $this->cachedFullStatePath = implode('.', $pathComponents);
    }

    protected function flushCachedStatePath(): void
    {
        unset($this->cachedFullStatePath);
    }
}
