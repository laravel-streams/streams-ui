<?php

namespace Streams\Ui\Livewire\Pages;

use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Livewire\Tables\InteractsWithTable;

class ListEntries extends PanelPage
{
    use InteractsWithTable;

    protected static string $view = 'ui::pages.list-entries';

    public function table(Table $table): Table
    {
        return static::getResource()::table($table);
    }
}
