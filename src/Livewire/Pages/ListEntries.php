<?php

namespace Streams\Ui\Livewire\Pages;

use Streams\Ui\Builders\Tables\Table;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Livewire\Tables\InteractsWithTable;

class ListEntries extends PanelPage
{
    use InteractsWithTable;

    protected static string $view = 'ui::livewire.pages.list-entries';

    public function table(Table $table): Table
    {
        $stream = static::getResource()::getStream();

        $table->query(fn () => Streams::entries($stream));

        return static::getResource()::table($table);
    }
}
