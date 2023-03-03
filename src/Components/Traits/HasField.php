<?php

namespace Streams\Ui\Components\Traits;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

trait HasField
{
    public ?string $field;

    public function field(): Stream|null
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
