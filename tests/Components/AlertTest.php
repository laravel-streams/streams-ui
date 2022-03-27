<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Components\Alert;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class AlertTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Alert::class, UI::make('alert'));
    }

    public function test_it_renders()
    {
        $this->assertIsString(UI::make('alert')->render());
    }
}
