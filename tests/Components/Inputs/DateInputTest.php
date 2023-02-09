<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class DateInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('date', [
            'name' => 'example',
        ])->assertSeeHtml('type="date"');
    }
}
