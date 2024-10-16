<?php

namespace Streams\Ui\Traits;

use Streams\Core\Entry\Entry;
use Illuminate\Database\Eloquent\Model;

trait HasEntry
{
    public Entry | Model | string | null $entry = null;

    public function entry(Entry | \Closure | string | null $entry = null): static
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

    public function getEntry()
    {
        $entry = $this->entry;

        if ($entry instanceof Entry) {
            return $entry->getIdAttribute();
        }

        if (filled($entry)) {
            return $entry;
        }

        return null;
        // return $this->getParentComponent()?->getEntry();
    }

    public function getEntryInstance(): ?Entry
    {
        $entry = $this->entry;

        if ($entry === null) {
            // return $this->getParentComponent()?->getEntryInstance();
        }

        if ($entry instanceof Entry) {
            return $entry;
        }

        $instance = $this->getStreamInstance()?->repository()->find($entry);

        return $this->entry = $instance;
    }
}
