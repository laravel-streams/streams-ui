<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class RangeInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('range', [
            'name' => 'example',
        ])->assertSeeHtml('type="range"');
    }
}
