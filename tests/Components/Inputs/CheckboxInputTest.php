<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Inputs\CheckboxInput;

class CheckboxInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(CheckboxInput::class, [
            'name' => 'example',
            'label' => 'Is this an example?',
        ])
        ->assertSeeHtml('type="checkbox"')
        ->assertSee('Is this an example?');
    }
}
