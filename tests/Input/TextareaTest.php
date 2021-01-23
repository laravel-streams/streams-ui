<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Textarea;
use Streams\Core\Support\Facades\Streams;

class TextareaTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->textarea->input();

        $this->assertInstanceOf(Textarea::class, $input);
    }

    public function testAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->textarea;
        $input = $field->input();

        $this->assertStringContainsString('rows="10"', $input->htmlAttributes());
    }
}
