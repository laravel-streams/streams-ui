<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class BasicInputTest extends UiTestCase
{
    public function test_it_renders_an_input()
    {
        Livewire::test('input', [
            'name' => 'example',
        ])->assertSeeHtml([
            'type="text"',
            'name="example"',
        ]);
    }

    public function test_it_suports_input_types()
    {
        Livewire::test('input', [
            'name' => 'favorite',
            'type' => 'color',
        ])->assertSeeHtml([
            'type="color"',
            'name="favorite"',
        ]);
    }

    public function test_it_suports_min_max()
    {
        Livewire::test('input', [
            'name' => 'example',
            'min' => 5,
            'max' => 25,
        ])->assertSeeHtml([
            'minlength="5"',
            'maxlength="25"',
            'name="example"',
        ]);

        Livewire::test('input', [
            'name' => 'example',
            'type' => 'number',
            'min' => 5,
            'max' => 25,
        ])->assertSeeHtml([
            'min="5"',
            'max="25"',
            'type="number"',
            'name="example"',
        ]);
    }
}
