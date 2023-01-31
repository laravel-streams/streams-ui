<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\RangeInput;

class RangeInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(RangeInput::class, Livewire::getInstance('range', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('range', [
            'name' => 'test',
        ])->html();

        $this->assertStringContainsString('type="range"', $output);
    }
}
