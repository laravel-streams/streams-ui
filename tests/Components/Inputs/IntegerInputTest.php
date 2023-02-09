<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class IntegerInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('integer', [
            'name' => 'example',
        ])->assertSeeHtml('type="number"');
    }
}
