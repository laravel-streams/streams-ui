<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Date;
use Streams\Core\Support\Facades\Streams;

class DateTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->date->input();

        $this->assertInstanceOf(Date::class, $input);
    }

    public function testAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->date;
        $input = $field->input();

        $this->assertStringContainsString('type="date"', $input->htmlAttributes());
    }
}
