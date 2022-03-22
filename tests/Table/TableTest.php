<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Tests\UiTestCase;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;

class TableTest extends UiTestCase
{

    public function test_it_is_selectable()
    {
        $stream = Streams::make('films');

        $table = $stream->table();

        $this->assertEquals(false, $table->isSelectable());

        $table->options->put('selectable', true);

        $table->actions = collect(['test']);

        $this->assertEquals(true, $table->isSelectable());

        $table->actions = new Collection();

        $this->assertEquals(false, $table->isSelectable());
    }

    public function test_it_is_sortable()
    {
        $stream = Streams::make('films');

        $table = $stream->table();

        $this->assertEquals(false, $table->isSortable());
    }
}
