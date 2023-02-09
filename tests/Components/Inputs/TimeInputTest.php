<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class TimeInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('time', [
            'name' => 'example',
        ])->assertSeeHtml('type="time"');
    }
}
