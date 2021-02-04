<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Color;
use Streams\Core\Support\Facades\Streams;

class ColorTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInitializePrototype()
    {
        $input = Streams::make('testing.litmus')->fields->color->input();

        $this->assertInstanceOf(Color::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->color->input();

        $this->assertStringContainsString('type="color"', $input->htmlAttributes());
    }
}
