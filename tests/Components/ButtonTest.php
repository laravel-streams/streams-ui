<?php

namespace Streams\Ui\Tests\Components;

use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Facades\UI;

class ButtonTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Button::class, UI::make('button'));
    }

    public function test_it_renders()
    {
        $this->assertIsString(UI::make('button')->render());
    }
}
