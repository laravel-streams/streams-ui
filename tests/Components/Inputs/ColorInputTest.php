<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\ColorInput;

class ColorInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(ColorInput::class, Livewire::getInstance('color', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('color', [
            'name' => 'test',
        ])->html();

        $this->assertStringContainsString('type="color"', $output);
    }
}
