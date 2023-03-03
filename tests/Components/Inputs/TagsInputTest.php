<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class TagsInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('tags', [
            'name' => 'example',
        ])->assertSee('type="text"');
    }
}
