<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class AnchorTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('anchor', [
            'text' => 'Hello World',
        ])->assertSee('Hello World');
    }
}
