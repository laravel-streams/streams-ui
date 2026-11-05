<?php

namespace Streams\Ui\Tests\Fixtures\Todos\Pages;

use Streams\Ui\Livewire\Pages\ListEntries;
use Streams\Ui\Tests\Fixtures\Todos\TodoResource;

class ListTodos extends ListEntries
{
    protected static string $resource = TodoResource::class;
}
