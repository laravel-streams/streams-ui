<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Datetime;
use Streams\Core\Support\Facades\Streams;

class DatetimeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->datetime->input();

        $this->assertInstanceOf(Datetime::class, $input);
    }

    public function testAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->datetime;
        $input = $field->input();

        $this->assertStringContainsString('type="datetime-local"', $input->htmlAttributes());
    }
}
