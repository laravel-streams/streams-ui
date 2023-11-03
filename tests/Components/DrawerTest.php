<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Drawer;

class DrawerTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Drawer::class)
            ->assertSeeHtml('<div');
    }
}
