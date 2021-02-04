<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Integer;
use Streams\Core\Support\Facades\Streams;

class IntegerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInitializePrototype()
    {
        $input = Streams::make('testing.litmus')->fields->integer->input();

        $this->assertInstanceOf(Integer::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->integer->input();

        $this->assertStringContainsString('type="number"', $input->htmlAttributes());
        $this->assertStringContainsString('step="1"', $input->htmlAttributes());
        $this->assertStringContainsString('min="-1"', $input->htmlAttributes());
        $this->assertStringContainsString('max="1"', $input->htmlAttributes());
    }
}
