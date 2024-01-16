<?php

namespace Streams\Ui\Tables\Concerns;

use Livewire\Component;
use Streams\Ui\Tables\Table;

trait BelongsToTable
{
    protected Table $table;

    public function table(Table $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): Table
    {
        return $this->table;
    }

    public function getLivewire(): Component
    {
        return $this->getTable()->getLivewire();
    }

    public function getState(): array
    {
        return $this->getLivewire()->getTableFilterState($this->getName()) ?? [];
    }
}
