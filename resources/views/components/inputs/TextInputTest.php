<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\TextInput;

class TextInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(TextInput::class, Livewire::getInstance('text', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('text', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->html();

        $this->assertStringContainsString('type="text"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
