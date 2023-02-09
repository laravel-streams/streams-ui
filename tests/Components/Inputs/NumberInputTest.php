<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class NumberInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('number', [
            'name' => 'example',
        ])->assertSeeHtml('type="number"');
    }
}
