<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Button\Button;
use Streams\Ui\Support\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Support\Value;

class ValueTest extends UiTestCase
{
    public function test_it_returns_string()
    {
        $this->assertIsString(Value::make('Foo {entry.name}', [
            'name' => 'Bar',
        ]));
    }
}
