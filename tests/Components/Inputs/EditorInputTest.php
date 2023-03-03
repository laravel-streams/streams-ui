<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class EditorInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('editor', [
            'name' => 'example',
        ])->assertSee('MonacoEnvironment');
    }

    // public function test_it_supports_objects()
    // {
    //     UI::test('editor', [
    //         'name' => 'example',
    //         'value' => (object) [
    //             'foo' => 'bar',
    //         ],
    //     ])
    //     ->assertSee('MonacoEnvironment')
    //     ->assertSee(json_encode([
    //         'foo' => 'bar',
    //     ]));
    // }
}
