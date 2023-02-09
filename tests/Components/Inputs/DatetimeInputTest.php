<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class DatetimeInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('datetime-input', [
            'name' => 'example',
        ])->assertSeeHtml('type="datetime-local"');
    }
}
