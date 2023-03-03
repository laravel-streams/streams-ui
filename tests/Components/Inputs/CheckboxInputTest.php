<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class CheckboxInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('checkbox', [
            'name' => 'example',
        ])
        ->assertSee('type="checkbox"');
    }
}
