<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Core\Field\Field;
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

    public function test_it_supports_fields()
    {
        $field = Livewire::test('field', [
            'stream' => 'films',
            'field' => 'title',
        ])
            ->instance()
            ->field();

        $this->assertInstanceOf(Field::class, $field);
    }

    public function test_it_can_disable_lables()
    {
        Livewire::test('field', [
            'stream' => 'films',
            'field' => 'title',
            'label' => false,
        ])
            ->assertDontSeeHtml('Title')
            ->assertSeeHtml('name="title"')
            ->assertSeeHtml('type="text"');
    }
}
