<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Markdown;
use Streams\Core\Support\Facades\Streams;

class MarkdownTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->markdown->input();

        $this->assertInstanceOf(Markdown::class, $input);
    }

    public function testHtmlAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->markdown;
        $input = $field->input();

        $this->assertStringContainsString('rows="10"', $input->htmlAttributes());
    }
}
