<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Slug;
use Streams\Core\Support\Facades\Streams;

class SlugTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->slug->input();

        $this->assertInstanceOf(Slug::class, $input);
    }

    public function testHtmlAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->slug;
        $input = $field->input();

        $this->assertStringContainsString('type="text"', $input->htmlAttributes());
    }
}
