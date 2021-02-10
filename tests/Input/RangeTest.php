<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Range;
use Streams\Core\Support\Facades\Streams;

class RangeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->range->input();

        $this->assertInstanceOf(Range::class, $input);
    }

    public function testHtmlAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->range;
        $input = $field->input();

        $this->assertStringContainsString('min="0"', $input->htmlAttributes());
        $this->assertStringContainsString('max="100"', $input->htmlAttributes());
    }
}
