<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class EmailInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('email', [
            'name' => 'example',
        ])->assertSeeHtml('type="email"');
    }
}
