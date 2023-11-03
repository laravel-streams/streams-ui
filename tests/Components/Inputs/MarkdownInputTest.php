<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Inputs\MarkdownInput;

class MarkdownInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(MarkdownInput::class, [
            'name' => 'example',
        ])->assertSeeHtml('x-ref="editor"');
    }
}
