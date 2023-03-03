<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class MarkdownInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('markdown', [
            'name' => 'example',
        ])->assertSee('x-ref="editor"');
    }
}
