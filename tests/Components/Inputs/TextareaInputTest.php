<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\TextareaInput;

class TextareaInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(TextareaInput::class, Livewire::getInstance('textarea', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('textarea', [
            'name' => 'test',
        ])->html();

        $this->assertStringContainsString('<textarea', $output);
    }
}
