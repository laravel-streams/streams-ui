<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\SelectInput;

class SelectInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(SelectInput::class, Livewire::getInstance('select', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('select', [
            'name' => 'test',
        ])->html();

        $this->assertStringContainsString('<select', $output);
    }
}
