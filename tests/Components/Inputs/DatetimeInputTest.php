<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\DatetimeInput;

class DatetimeInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(DatetimeInput::class, Livewire::getInstance('date_time', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('date_time', [
            'name' => 'test',
        ])->html();

        $this->assertStringContainsString('type="datetime-local"', $output);
    }
}
