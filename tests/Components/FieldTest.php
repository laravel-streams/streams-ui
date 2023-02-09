<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class FieldTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('field', [
            'label' => 'Example',
        ])->assertSee('Example');
    }

    public function test_it_supports_streams()
    {
        Livewire::test('field', [
            'stream' => 'films',
            'field' => 'title',
        ])
        ->assertSeeHtml('Title')
        ->assertSeeHtml('name="title"')
        ->assertSeeHtml('type="text"');
    }
}
