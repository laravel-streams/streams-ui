<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\TimeInput;

class TimeInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(TimeInput::class, Livewire::getInstance('time', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('time', [
            'name' => 'test',
        ])->html();

        $this->assertStringContainsString('type="time"', $output);
    }
}
