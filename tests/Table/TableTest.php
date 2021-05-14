<?php

namespace Streams\Ui\Tests\Support;

use Tests\TestCase;
use Streams\Ui\Table\Table;
use Illuminate\Support\Collection;
use Streams\Core\Repository\Repository;
use Streams\Core\Support\Facades\Streams;

class TableTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/examples.json'));
    }

    public function testIsSelectable()
    {
        $stream = Streams::make('testing.examples');

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
