<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class SlugInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('slug', [
            'name' => 'example',
        ])->assertSee('x-model="value"');
    }
}
