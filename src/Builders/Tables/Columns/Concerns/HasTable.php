<?php

namespace Streams\Ui\Builders\Tables\Columns\Concerns;

use Streams\Ui\Builders\Tables\Table;

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

    public function getLivewire()//: \Streams\Ui\Builders\Tables\Concerns\HasTable
    {
        return $this->getTable()->getLivewire();
    }
}
