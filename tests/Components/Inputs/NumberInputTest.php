<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\NumberInput;

class NumberInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(NumberInput::class, Livewire::getInstance('number', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('number', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->html();

        $this->assertStringContainsString('type="number"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
