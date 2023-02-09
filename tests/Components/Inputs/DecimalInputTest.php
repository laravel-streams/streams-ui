<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class DecimalInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('decimal', [
            'name' => 'example',
        ])->assertSeeHtml('type="number"');
    }
}
