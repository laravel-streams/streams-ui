<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Components\Input;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;

class InputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Input::class, Livewire::getInstance('input', 1));
    }

    public function test_it_renders()
    {
        $this->assertIsString(Livewire::mount('input', [
            'name' => 'test',
        ])->html());
    }
}
