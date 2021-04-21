<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Checkbox;
use Streams\Core\Support\Facades\Streams;

class CheckboxTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testinitializePrototypeAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->checkbox->input();

        $this->assertInstanceOf(Checkbox::class, $input);
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->checkbox->input();

        $this->assertStringContainsString('type="checkbox"', $input->htmlAttributes());
    }
}
