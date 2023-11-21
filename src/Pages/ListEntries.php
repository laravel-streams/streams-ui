<?php

namespace Streams\Ui\Pages;

use Streams\Ui\Tables\Table;
use Streams\Ui\Tables\Concerns\HasTable;

class ListEntries extends Page
{
    use HasTable;

    protected static string $view = 'ui::pages.list-entries';

    public function table(Table $table): Table
    {
        return static::getResource()::table($table);
    }
}
