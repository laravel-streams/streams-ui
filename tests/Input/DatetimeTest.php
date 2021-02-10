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

    public function testInitializePrototype()
    {
        $input = Streams::make('testing.litmus')->fields->datetime->input();

        $this->assertInstanceOf(Datetime::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->datetime->input();

        $this->assertStringContainsString('type="datetime-local"', $input->htmlAttributes());
        $this->assertStringContainsString('min="2021-01-01T12:00"', $input->htmlAttributes());
        $this->assertStringContainsString('max="2121-01-01T12:00"', $input->htmlAttributes());
        $this->assertStringContainsString('step="2"', $input->htmlAttributes());
    }
}
