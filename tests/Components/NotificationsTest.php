<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Notifications;

class NotificationsTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Notifications::class)
        ->assertSee('inset-0');
    }
}
