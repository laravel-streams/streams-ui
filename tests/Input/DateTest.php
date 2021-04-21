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

    public function testinitializePrototypeInstance()
    {
        $input = Streams::make('testing.litmus')->fields->date->input();

        $this->assertInstanceOf(Date::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->date->input();

        $this->assertStringContainsString('type="date"', $input->htmlAttributes());
        $this->assertStringContainsString('min="2021-01-01"', $input->htmlAttributes());
        $this->assertStringContainsString('max="2121-01-01"', $input->htmlAttributes());
    }
}
