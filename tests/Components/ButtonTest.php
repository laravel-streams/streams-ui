<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class ButtonTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('button', [
            'text' => 'Hello World',
        ])->assertSee('Hello World');
    }
}
