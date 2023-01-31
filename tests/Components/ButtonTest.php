<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Field as StreamsField;

class ButtonTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Button::class, Livewire::getInstance('button', 1));
    }

    public function test_it_renders()
    {
        $this->assertIsString(Livewire::mount('button')->html());
    }
}
