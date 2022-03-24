<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\ControlPanel\ControlPanel;

class ControlPanelTest extends UiTestCase
{

    public function test_it_supports_attributes()
    {
        $this->assertInstanceOf(ControlPanel::class, UI::make('cp'));
    }
}
