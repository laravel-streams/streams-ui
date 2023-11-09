<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Badge;

class BadgeTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Badge::class, [
            'text' => 'Testing',
        ])
        ->assertSee('Testing');
    }
}
