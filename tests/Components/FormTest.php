<?php

namespace Streams\Ui\Tests\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Components\Form;
use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;

class FormTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Form::class, UI::make('form'));
    }

    public function test_it_renders()
    {
        $this->assertIsString(UI::make('form', [])->render());
    }

    public function test_it_defaults_stream_fields()
    {
        $instance = UI::make('form', [
            'stream' => 'films',
        ]);

        $this->assertTrue(count($instance->fields) > 1);
    }

    public function test_it_passes_stream()
    {
        $instance = UI::make('form', [
            'stream' => 'films',
            'fields' => [
                ['field' => 'title'],
            ],
        ]);

        $this->assertSame('films', $instance->fields[0]['stream']);
    }
}
