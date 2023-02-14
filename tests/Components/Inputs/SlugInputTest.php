<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class SlugInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('slug', [
            'name' => 'example',
        ])->assertSeeHtml('x-model="value"');
    }
}
