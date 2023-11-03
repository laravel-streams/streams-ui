<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Inputs\SlugInput;

class SlugInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(SlugInput::class, [
            'name' => 'example',
        ])->assertSeeHtml('x-model="value"');
    }
}
