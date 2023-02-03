<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Component;
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

    public function test_it_registers_callable_components()
    {
        UI::register('test', function() {
            
            $instance = new UiManagerTestComponent();

            $instance->foo = 'Bar';

            return $instance;
        });

        $this->assertSame('Bar', UI::make('test')->foo);
    }

    public function test_it_fails_on_unregistered()
    {
        $this->expectException(\Exception::class);

        UI::make('foo');
    }

    public function test_it_detects_registered_components()
    {
        UI::register('test', UiManagerTestComponent::class);

        $this->assertTrue(UI::exists('test'));
    }

    public function test_it_only_boots_components_once()
    {
        UI::register('test', BootableUiManagerTestComponent::class);

        $this->expectOutputString('Booting!');

        UI::make('test');
        UI::make('test');
    }
}

class UiManagerTestComponent extends Component
{
    public string $template = 'ui::test';
}

class BootableUiManagerTestComponent extends Component
{
    public string $template = 'ui::test';

    public function boot()
    {
        echo 'Booting!';
    }
}
