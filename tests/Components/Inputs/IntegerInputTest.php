<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\IntegerInput;

class IntegerInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(IntegerInput::class, Livewire::getInstance('integer', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('integer', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->html();

        $this->assertStringContainsString('type="number"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
