<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Collapsable;

class CollapsableTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Collapsable::class)
            ->assertSeeHtml('<div');
    }
}
