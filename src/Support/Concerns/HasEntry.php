<?php

namespace Streams\Ui\Builders\Concerns;

use Streams\Core\Entry\Entry;

trait HasEntry
{
    public Entry | string | null $entry = null;

    public function entry(Entry | string | null $entry = null): static
    {
        $this->entry = $entry;

        return $this;
    }

    // public function saveRelationships(): void
    // {
    //     foreach ($this->getComponents(withHidden: true) as $component) {
    //         $component->saveRelationshipsBeforeChildren();

    //         foreach ($component->getChildComponentContainers(withHidden: $component->shouldSaveRelationshipsWhenHidden()) as $container) {
    //             $container->saveRelationships();
    //         }

    //         $component->saveRelationships();
    //     }
    // }

    // public function loadStateFromRelationships(bool $andHydrate = false): void
    // {
    //     foreach ($this->getComponents(withHidden: true) as $component) {
    //         $component->loadStateFromRelationships($andHydrate);

    //         foreach ($component->getChildComponentContainers(withHidden: true) as $container) {
    //             $container->loadStateFromRelationships($andHydrate);
    //         }
    //     }
    // }

    public function getEntry(): ?string
    {
        $entry = $this->entry;

        if ($entry instanceof Entry) {
            return $entry->getIdAttribute();
        }

        if (filled($entry)) {
            return $entry;
        }

        return $this->getParentComponent()?->getEntry();
    }

    public function getEntryInstance(): ?Entry
    {
        $entry = $this->entry;

        if ($entry === null) {
            return $this->getParentComponent()?->getEntryInstance();
        }

        if ($entry instanceof Entry) {
            return $entry;
        }

        $instance = $this->getStreamInstance()?->repository()->find($entry);

        return $this->entry = $instance;
    }
}
