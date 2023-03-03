<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;

class AnchorTest extends UiTestCase
{
    public function test_it_renders()
    {
        $output = UI::make('anchor', [
            'text' => 'Hello World',
        ])->render();

        $this->assertStringContainsString('Hello World', $output);
    }
}
