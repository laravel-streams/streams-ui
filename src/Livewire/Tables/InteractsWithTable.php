<?php

namespace Streams\Ui\Livewire\Tables;

/**
 * Livewire table integration documented for list and page components.
 *
 * {@see InteractsWithTables} holds the shared table cache and query state.
 */
trait InteractsWithTable
{
    use InteractsWithTables;

    public function bootedInteractsWithTable(): void
    {
        $this->bootedInteractsWithTables();
    }
}
