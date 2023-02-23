<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class TabsTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('tabs')->assertSeeHtml('<nav');
    }
}
