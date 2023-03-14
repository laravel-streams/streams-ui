<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class FormTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('form', [
            'stream' => 'films',
        ])
        ->assertSee('<form')
        ->assertSee('name="title"');
    }

    public function test_it_supports_entries()
    {
        UI::test('form', [
            'stream' => 'films',
            'entry' => 4,
        ])->assertSee('A New Hope');
    }

    public function test_it_can_save_entries()
    {
        $response = $this->post('/streams/ui/form/save', [
            'stream' => 'films',
            'entry' => 4,
            'title' => 'A New Hope (Test)',
        ]);

        $response->assertStatus(200);
    }
}
