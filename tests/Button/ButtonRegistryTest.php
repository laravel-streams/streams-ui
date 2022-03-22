<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\Buttons;

class ButtonRegistryTest extends UiTestCase
{

    public function test_it_registers_button_configurations()
    {
        Buttons::register('test_button', [
            'text' => 'Foo Bar',
        ]);

        $this->assertSame([
            'text' => 'Foo Bar',
        ], Buttons::get('test_button'));
    }

    public function test_it_provides_accessor_methods()
    {
        Buttons::setButtons([
            'test_button' => [
                'text' => 'Foo Bar',
            ]
        ]);

        $this->assertSame([
            'test_button' => [
                'text' => 'Foo Bar',
            ]
        ], Buttons::getButtons());
    }
}
