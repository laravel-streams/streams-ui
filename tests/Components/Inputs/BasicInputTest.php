<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class BasicInputTest extends UiTestCase
{
    public function test_it_renders_an_input()
    {
        UI::test('input', [
            'name' => 'example',
        ])->assertSee([
            'type="text"',
            'name="example"',
        ]);
    }

    public function test_it_suports_input_types()
    {
        UI::test('input', [
            'name' => 'favorite',
            'type' => 'color',
        ])->assertSee([
            'type="color"',
            'name="favorite"',
        ]);
    }

    public function test_it_suports_min_max()
    {
        UI::test('input', [
            'name' => 'example',
            'min' => 5,
            'max' => 25,
        ])->assertSee([
            'minlength="5"',
            'maxlength="25"',
            'name="example"',
        ]);

        UI::test('input', [
            'name' => 'example',
            'type' => 'number',
            'min' => 5,
            'max' => 25,
        ])->assertSee([
            'min="5"',
            'max="25"',
            'type="number"',
            'name="example"',
        ]);
    }
}
