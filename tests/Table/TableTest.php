<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Tests\UiTestCase;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;

class TableTest extends UiTestCase
{

    public function testIsSelectable()
    {
        $stream = Streams::make('films');

        $table = $stream->table();

        $this->assertEquals(true, $table->isSelectable());

        $table->options->put('selectable', false);

        $this->assertEquals(true, $table->isSelectable());

        $table->actions = new Collection();

        $this->assertEquals(false, $table->isSelectable());
    }

    public function testIsSortable()
    {
        $stream = Streams::make('testing.examples');

        $table = $stream->table();

        $this->assertEquals(false, $table->isSortable());
    }
}
