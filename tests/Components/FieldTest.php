<?php

namespace Streams\Ui\Tests\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class FieldTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('field', [
            'label' => 'Example',
        ])->assertSee('Example');
    }

    public function test_it_supports_streams()
    {
        UI::test('field', [
            'stream' => 'films',
            'field' => 'title',
            'label' => true,
        ])->assertSee([
            'Title',
            'name="title"',
            'type="text"'
        ]);
    }

    public function test_it_supports_fields()
    {
        $testable = UI::test('field', [
            'stream' => 'films',
            'field' => 'title',
        ]);

        $this->assertInstanceOf(Field::class, $testable->field());
    }

    public function test_it_can_disable_lables()
    {
        UI::test('field', [
            'stream' => 'films',
            'field' => 'title',
        ])
        ->assertNotSee('Title')
        ->assertSee(['name="title"', 'type="text"']);
    }
}
