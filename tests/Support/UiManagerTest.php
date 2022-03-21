<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Button\Button;
use Streams\Ui\Support\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class UiManagerTest extends UiTestCase
{
    public function test_it_makes_ui_components()
    {
        $this->assertInstanceOf(Button::class, UI::make('button'));
    }

    public function test_it_registers_ui_components()
    {
        UI::register('test', UiManagerTestComponent::class);

        $this->assertInstanceOf(UiManagerTestComponent::class, UI::make('test'));
    }
}

class UiManagerTestComponent extends Component
{

}
