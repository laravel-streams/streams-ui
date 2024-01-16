<?php

namespace Streams\Ui\Tables\Columns\Concerns;

use Streams\Ui\Tables\Table;

trait HasTable
{
    protected ?Table $table = null;

    public function table(?Table $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): Table
    {
        return $this->table ?? $this->getLayout()->getTable();
    }

    public function getLivewire()//: \Streams\Ui\Tables\Concerns\HasTable
    {
        return $this->getTable()->getLivewire();
    }
}
