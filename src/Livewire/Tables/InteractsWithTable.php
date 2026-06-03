<?php

namespace Streams\Ui\Livewire\Tables;

/**
 * @deprecated Use {@see InteractsWithTables} instead.
 */
trait InteractsWithTable
{
    use InteractsWithTables;

    public function bootedInteractsWithTable(): void
    {
        $this->bootedInteractsWithTables();
    }
}
