<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class ModalTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('modal')->assertSee('x-show="open"');
    }
}
