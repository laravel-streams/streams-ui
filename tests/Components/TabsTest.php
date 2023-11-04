<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Components\Tabs;
use Streams\Ui\Tests\UiTestCase;

class TabsTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Tabs::class)
            ->assertSeeHtml('<nav');
    }
}
