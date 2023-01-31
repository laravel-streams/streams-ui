<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Buttons;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;

class ButtonsTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Buttons::class, Livewire::getInstance('buttons', 1));
    }

    public function test_it_renders()
    {
        $this->assertIsString(Livewire::mount('fields', [])->html());
    }
}
