<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Toggle;
use Streams\Core\Support\Facades\Streams;

class ToggleTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testinitializePrototypeTrait()
    {
        $input = Streams::make('testing.litmus')->fields->toggle->input();

        $this->assertInstanceOf(Toggle::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->toggle->input();

        $this->assertStringContainsString('type="checkbox"', $input->htmlAttributes());
    }
}
