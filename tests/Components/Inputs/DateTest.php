<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Date;
use Streams\Core\Support\Facades\Streams;

class DateTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Date::class, UI::make('date'));
    }

    public function test_it_renders()
    {
        $output = UI::make('date', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('type="date"', $output);
    }
}
