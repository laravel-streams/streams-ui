<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Navigation;

class NavigationTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Navigation::class)
            ->assertSeeHtml('<nav');
    }
}
