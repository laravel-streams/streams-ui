<?php

namespace Streams\Ui\Tests\Support\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\ControlPanel;

class ControlPanelTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(ControlPanel::class, UI::make('cp'));
    }

    public function test_it_renders()
    {
        $this->assertIsString(UI::make('cp')->render());
    }
}
