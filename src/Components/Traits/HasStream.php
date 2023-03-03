<?php

namespace Streams\Ui\Components\Traits;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

trait HasStream
{
    public ?string $stream;

    public function stream(): Stream|null
    {
        if (!$this->stream) {
            return null;
        }
        
        return $this->once(
            __METHOD__ . '.' . $this->stream,
            fn ()  => Streams::exists($this->stream) ? Streams::make($this->stream) : null
        );
    }
}
