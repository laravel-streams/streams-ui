<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Range;
use Streams\Core\Support\Facades\Streams;

class RangeTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Range::class, UI::make('range'));
    }

    public function test_it_renders()
    {
        $output = UI::make('range', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('type="range"', $output);
    }
}
