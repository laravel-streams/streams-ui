<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\Datetime;

class DatetimeTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Datetime::class, UI::make('datetime'));
    }

    public function test_it_renders()
    {
        $output = UI::make('datetime', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('type="datetime-local"', $output);
    }
}
