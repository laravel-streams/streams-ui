<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class TextareaInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('textarea', [
            'name' => 'example',
        ])->assertSee('<textarea');
    }
}
