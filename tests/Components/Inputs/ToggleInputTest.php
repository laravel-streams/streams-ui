<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Inputs\ToggleInput;

class ToggleInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(ToggleInput::class, [
            'name' => 'example',
            'label' => 'Is this an example?',
        ])
        ->assertSeeHtml('type="checkbox"')
        ->assertSee('Is this an example?');
    }
}
