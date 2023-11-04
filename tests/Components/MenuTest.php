<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Components\Menu;
use Streams\Ui\Tests\UiTestCase;

class MenuTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Menu::class)
            ->assertSeeHtml('<menu');
    }
}
