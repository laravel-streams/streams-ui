<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Time;
use Streams\Core\Support\Facades\Streams;

class TimeTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Time::class, UI::make('time'));
    }

    public function test_it_renders()
    {
        $output = UI::make('time', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('type="time"', $output);
    }
}
