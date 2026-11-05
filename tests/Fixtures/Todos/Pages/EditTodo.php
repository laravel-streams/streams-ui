<?php

namespace Streams\Ui\Tests\Fixtures\Todos\Pages;

use Streams\Ui\Livewire\Pages\EditEntry;
use Streams\Ui\Tests\Fixtures\Todos\TodoResource;

class EditTodo extends EditEntry
{
    protected static string $resource = TodoResource::class;
}
