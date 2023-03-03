<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class SelectInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('select', [
            'name' => 'example',
        ])->assertSee('<select');
    }

    public function test_it_returns_options()
    {
        UI::test('select', [
            'name' => 'example',
            'options' => [
                'one' => 'One',
                'two' => 'Two',
            ],
        ])
        ->assertSee('value="one">One</option>')
        ->assertSee('value="two">Two</option>');
    }

    public function test_it_supports_field_config()
    {
        UI::test('select', [
            'name' => 'example',
            'stream' => 'people',
            'field' => 'gender',
        ])
        ->assertSee('value="male">Male</option>')
        ->assertSee('value="female">Female</option>');
    }
}
