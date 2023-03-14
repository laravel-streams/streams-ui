<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class DropdownTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('dropdown', [
            'toggle' => [
                [
                    'component' => 'button',
                    'text' => 'Dropdown Toggle',
                ],
            ],
            'components' => [
                [
                    'url' => '#',
                    'text' => 'Anchor 1',
                    'component' => 'anchor',
                ],
            ],
        ])
        ->assertSee('Dropdown Toggle')
        ->assertSee('Anchor 1');
    }
}
