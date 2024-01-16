<?php

namespace Streams\Ui\Pages;

use Livewire\WithPagination;
use Streams\Ui\Tables\Table;
use Streams\Ui\Components\Tables\InteractsWithTable;

class ListEntries extends PanelPage
{
    use WithPagination;
    use InteractsWithTable;

    protected static string $view = 'ui::pages.list-entries';

    public function table(Table $table): Table
    {
        return static::getResource()::table($table);
    }
}
