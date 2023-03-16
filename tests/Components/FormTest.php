<?php

namespace Streams\Ui\Tests\Components;

use Streams\Core\Support\Facades\Streams;
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
        $this->withoutExceptionHandling();

        $query = http_build_query([
            'stream' => 'films',
            'entry' => 4,
        ]);

        $response = $this->post('/streams/ui/form/save?' . $query, [
            'title' => 'A New Hope (Test)',
        ]);

        $entry = Streams::repository('films')->find(4);

        $response->assertStatus(302);

        $this->assertEquals('A New Hope (Test)', $entry->title);
    }
}
