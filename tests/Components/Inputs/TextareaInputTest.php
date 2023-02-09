<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class TextareaInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('textarea', [
            'name' => 'example',
        ])->assertSeeHtml('<textarea');
    }
}
