<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class ColorInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('color', [
            'name' => 'example',
        ])->assertSeeHtml('type="color"');
    }
}
