<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class TextInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('text', [
            'name' => 'example',
        ])->assertSeeHtml('type="text"');
    }
}
