<?php

namespace Streams\Ui\Support\Concerns;

use Streams\Core\Entry\Entry;
use Illuminate\Database\Eloquent\Model;

trait HasRecord
{
    protected Entry | Model | array $record = [];

    public function record(Entry | Model | array $record): static
    {
        $this->record = $record;

        return $this;
    }

    public function getRecord(): Entry | Model | array
    {
        return $this->record;// ?? $this->getLayout()?->getRecord();
    }
}
