<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class SelectInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('select', [
            'name' => 'example',
        ])->assertSeeHtml('<select');
    }

    public function test_it_returns_options()
    {
        Livewire::test('select', [
            'name' => 'example',
            'options' => [
                'one' => 'One',
                'two' => 'Two',
            ],
        ])
        ->assertSeeHtml('value="one">One</option>')
        ->assertSeeHtml('value="two">Two</option>');
    }

    public function test_it_supports_field_config()
    {
        Livewire::test('select', [
            'name' => 'example',
            'stream' => 'people',
            'field' => 'gender',
        ])
        ->assertSeeHtml('value="male">Male</option>')
        ->assertSeeHtml('value="female">Female</option>');
    }
}
