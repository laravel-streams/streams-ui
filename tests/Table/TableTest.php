<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Table\Row\Row;
use Streams\Ui\Tests\UiTestCase;
use Streams\Core\Support\Facades\Streams;

class TableTest extends UiTestCase
{

    public function test_it_has_rows()
    {
        dd(Streams::make('films')->entries()->count());
        $table = Streams::make('films')->ui('table');

        $this->assertInstanceOf(Row::class, $table->rows->first());
    }
}
