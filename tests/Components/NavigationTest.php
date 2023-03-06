<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class NavigationTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('navigation')->assertSee('<nav');
    }
}
