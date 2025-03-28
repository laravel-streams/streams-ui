<?php

namespace Streams\Ui\Traits;

use Streams\Core\Entry\Contract\EntryInterface;

trait HasEntry
{
    public $entry = null;

    public function entry($entry = null): static
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

        if ($entry instanceof EntryInterface) {
            return $entry->getIdAttribute();
        }

        if (filled($entry)) {
            return $entry;
        }

        return null;
        // return $this->getParentComponent()?->getEntry();
    }

    public function getEntryInstance()
    {
        $entry = $this->entry;

        if ($entry instanceof EntryInterface) {
            return $entry;
        }

        if ($entry === null && method_exists(static::class, 'getParentComponent')) {
            return $this->entry = $this->getParentComponent()?->getEntryInstance();
        }

        if ($entry === null && method_exists(static::class, 'getStreamInstance')) {
            return $this->entry = $this->getStreamInstance()
                ?->repository()
                ->find($entry);
        }

        return $this->entry;
    }
}
