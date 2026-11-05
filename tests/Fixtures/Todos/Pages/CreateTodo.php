<?php

namespace Streams\Ui\Tests\Fixtures\Todos\Pages;

use Streams\Ui\Livewire\Pages\CreateEntry;
use Streams\Ui\Tests\Fixtures\Todos\TodoResource;

class CreateTodo extends CreateEntry
{
    protected static string $resource = TodoResource::class;
}
