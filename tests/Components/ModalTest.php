<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class ModalTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('modal')->assertSeeHtml('x-show="open"');
    }
}
