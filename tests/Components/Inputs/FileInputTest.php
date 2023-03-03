<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class FileInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('file', [
            'name' => 'example',
        ])->assertSee('type="file"');
    }
}
