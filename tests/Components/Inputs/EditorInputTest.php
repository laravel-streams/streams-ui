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
        ])->assertSeeHtml('MonacoEnvironment');
    }
}
