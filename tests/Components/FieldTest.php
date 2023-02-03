<?php

namespace Streams\Ui\Tests\Components;

use Streams\Core\Stream\Stream;
use Streams\Ui\Components\Field;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Field as StreamsField;

class FieldTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Field::class, UI::make('field'));
    }

    public function test_it_renders()
    {
        $this->assertIsString(UI::make('field', [
            'name' => 'test',
        ])->render());
    }

    public function test_it_supports_streams()
    {
        $instance = UI::make('field', [
            'stream' => 'films',
            'field' => 'title',
        ]);

        $this->assertInstanceOf(Stream::class, $instance->stream());
        $this->assertInstanceOf(StreamsField::class, $instance->field());

        $instance->field = 'foo';

        $this->assertNull($instance->field());
    }

    public function test_it_defaults_to_stream_config()
    {
        $instance = UI::make('field', [
            'stream' => 'films',
            'field' => 'title',
        ]);

        $this->assertTrue($instance->required);
        $this->assertSame('title', $instance->name);
        $this->assertSame('Title', $instance->label);
        $this->assertSame('The title of the film.', $instance->description);
    }
}
