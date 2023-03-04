<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class CollapsableTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('collapsable')->assertSee('<div');
    }
}
