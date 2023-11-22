<?php

namespace Streams\Ui\Support\Concerns;

use Streams\Core\Entry\Entry;
use Illuminate\Database\Eloquent\Model;

trait HasEntry
{
    protected Entry | Model | array $entry = [];

    public function entry(Entry | Model | array $entry): static
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEntry(): Entry | Model | array
    {
        return $this->entry;// ?? $this->getLayout()?->getEntry();
    }
}
