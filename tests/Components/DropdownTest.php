<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class DropdownTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('dropdown', [
            'button' => [
                'text' => 'Dropdown Toggle',
            ],
            'content' => [
                [
                    'url' => '#',
                    'text' => 'Anchor 1',
                    'component' => 'anchor',
                ]
            ],
        ])
        ->assertSee('Dropdown Toggle')
        ->assertSee('Anchor 1');
    }
}
