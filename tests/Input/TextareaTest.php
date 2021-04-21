<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Textarea;
use Streams\Core\Support\Facades\Streams;

class TextareaTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testinitializePrototypeAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->textarea->input();

        $this->assertInstanceOf(Textarea::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->textarea->input();

        $this->assertStringContainsString('rows="10"', $input->htmlAttributes());
    }
}
