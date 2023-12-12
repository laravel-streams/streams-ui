<?php

namespace Streams\Ui\Pages;

use Livewire\WithPagination;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Tables\Concerns\HasTable;

class ListEntries extends Page
{
    use HasTable;
    use WithPagination;

    protected static string $view = 'ui::pages.list-entries';

    public function table(Table $table): Table
    {
        return static::getResource()::table($table);
    }
}