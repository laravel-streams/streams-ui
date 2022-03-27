<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Dropdown;

class DropdownTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Dropdown::class, UI::make('dropdown'));
    }

    public function test_it_renders()
    {
        $this->assertIsString(UI::make('dropdown')->render());
    }
}
