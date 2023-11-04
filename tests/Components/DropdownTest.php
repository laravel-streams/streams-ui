<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Dropdown;

class DropdownTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Dropdown::class, [
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
