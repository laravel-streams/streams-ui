<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class MarkdownInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('markdown', [
            'name' => 'example',
        ])->assertSeeHtml('x-ref="editor"');
    }
}
