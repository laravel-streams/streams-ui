<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Components\Card;
use Streams\Ui\Tests\UiTestCase;

class CardTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Card::class, [
            //'text' => 'Hello World',
        ])->assertSeeHtml('<div');
    }
}
