<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\DateInput;

class DateInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(DateInput::class, Livewire::getInstance('date', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('date', [
            'name' => 'test',
        ])->html();

        $this->assertStringContainsString('type="date"', $output);
    }
}
