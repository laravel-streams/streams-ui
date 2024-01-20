<?php

namespace Streams\Ui\Traits;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

trait HasStream
{
    protected Stream | string | null $stream = null;

    public function stream(Stream | string | null $stream = null): static
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream(): ?string
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
