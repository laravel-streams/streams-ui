<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Alerts;

class AlertsTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Alerts::class)
        ->assertSee('absolute');
    }
}
