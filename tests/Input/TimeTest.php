<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Time;
use Streams\Core\Support\Facades\Streams;

class TimeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInitializePrototype()
    {
        $input = Streams::make('testing.litmus')->fields->time->input();

        $this->assertInstanceOf(Time::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->time->input();

        $this->assertStringContainsString('type="time"', $input->htmlAttributes());
        $this->assertStringContainsString('min="06:00"', $input->htmlAttributes());
        $this->assertStringContainsString('max="20:00"', $input->htmlAttributes());
        $this->assertStringContainsString('step="1"', $input->htmlAttributes());
    }
}
