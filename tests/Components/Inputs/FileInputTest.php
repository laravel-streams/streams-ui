<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\FileInput;

class FileInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(FileInput::class, Livewire::getInstance('file', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('file', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->html();

        $this->assertStringContainsString('type="number"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
