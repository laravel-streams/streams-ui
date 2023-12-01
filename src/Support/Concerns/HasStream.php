<?php

namespace Streams\Ui\Support\Concerns;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

trait HasStream
{
    public Stream | string | null $stream = null;

    public function stream(Stream | string | null $stream = null): static
    {
        $this->stream = $stream;

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

    public function getStream(): ?string
    {
        $stream = $this->stream;

        if ($stream instanceof Stream) {
            return $stream->getIdAttribute();
        }

        if (filled($stream)) {
            return $stream;
        }

        return $this->stream = $this->getParentComponent()?->getStream();
    }

    public function getStreamInstance(): ?Stream
    {
        $stream = $this->stream;

        if ($stream === null) {
            return $this->getParentComponent()?->getStreamInstance();
        }

        if ($stream instanceof Stream) {
            return $stream;
        }

        return $this->stream = Streams::make($stream);
    }
}
