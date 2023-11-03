<?php

namespace Streams\Ui\Components\Traits;

trait HasField
{
    public function bootHasField(): void
    {
        if (!$this->stream) {
            return;
        }
        
        $key = __METHOD__ . '.' . $this->stream . '.' . $this->field;

        $this->field = $this->once($key, fn ()  => $this->stream->fields->{$this->field});
    }

    public function field()
    {
        return $this->field;
    }
}
