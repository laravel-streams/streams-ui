<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Indicator;

class IndicatorTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Indicator::class, [
            'text' => 'Testing',
        ])
        ->assertSee('Testing');
    }
}
