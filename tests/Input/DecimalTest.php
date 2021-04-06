<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Decimal;
use Streams\Core\Support\Facades\Streams;

class DecimalTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testinitializePrototypeTrait()
    {
        $input = Streams::make('testing.litmus')->fields->decimal->input();

        $this->assertInstanceOf(Decimal::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->decimal->input();

        $this->assertStringContainsString('type="number"', $input->htmlAttributes());
        $this->assertStringContainsString('step="0.01"', $input->htmlAttributes());
        $this->assertStringContainsString('min="-0.1"', $input->htmlAttributes());
        $this->assertStringContainsString('max="0.1"', $input->htmlAttributes());
    }
}
