<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Components\Button;
use Streams\Ui\Tests\UiTestCase;

class ButtonTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Button::class, [
            'text' => 'Hello World',
        ])->assertSee('Hello World');
    }
}
