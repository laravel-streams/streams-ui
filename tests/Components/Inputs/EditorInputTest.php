<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class EditorInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('editor', [
            'name' => 'example',
        ])->assertSee('MonacoEnvironment');
    }

    public function test_it_supports_objects()
    {
        Livewire::test('editor', [
            'name' => 'example',
            'value' => (object) [
                'foo' => 'bar',
            ],
        ])
        ->assertSee('MonacoEnvironment')
        ->assertSeeHtml('"foo": "bar"');
    }
}
