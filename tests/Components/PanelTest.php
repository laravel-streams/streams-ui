<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Panel;

class PanelTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Panel::class)
            ->assertSeeHtml('<body');
    }
}
