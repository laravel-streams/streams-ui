<?php

namespace Streams\Ui\Components\Traits;

use Streams\Core\Field\Field;

trait HasField
{
    public function field(): Field|null
    {
        if (!$this->stream) {
            return null;
        }
        
        $key = __METHOD__ . '.' . $this->stream . '.' . $this->field;

        return $this->once($key, fn ()  => $this->stream()->fields->{$this->field});
    }
}
