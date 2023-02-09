<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class CheckboxInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('checkbox', [
            'name' => 'example',
        ])->assertSeeHtml('type="checkbox"');
    }
}
