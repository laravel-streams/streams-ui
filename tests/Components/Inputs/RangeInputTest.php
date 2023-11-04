<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Inputs\RangeInput;

class RangeInputTest extends UiTestCase
{
    public function test_it_renders_an_input()
    {
        Livewire::test(RangeInput::class, [
            'name' => 'example',
        ])->assertSeeHtml([
            'type="range"',
            'name="example"',
        ]);
    }

    public function test_it_suports_min_max()
    {
        Livewire::test(RangeInput::class, [
            'name' => 'example',
            'min' => 5,
            'max' => 25,
        ])->assertSeeHtml([
            'min="5"',
            'max="25"',
            'name="example"',
        ]);
    }
}
