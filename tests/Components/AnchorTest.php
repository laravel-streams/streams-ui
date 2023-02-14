<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class AnchorTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('anchor', [
            'text' => 'Hello World',
        ])->assertSee('Hello World');
    }
}
