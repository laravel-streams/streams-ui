<?php

namespace Streams\Ui\Components\Traits;

use Streams\Core\Support\Facades\Streams;

trait HasStream
{
    // public function bootHasStream(): void
    // {
    //     if (!$this->stream) {
    //         return;
    //     }
        
    //     $this->stream = $this->once(
    //         __METHOD__ . '.' . $this->stream,
    //         fn ()  => Streams::exists($this->stream) ? Streams::make($this->stream) : null
    //     );
    // }
}
