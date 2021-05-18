<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Checkboxes;
use Streams\Core\Support\Facades\Streams;

class CheckboxesTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInitializePrototypeAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->checkboxes->input();

        $this->assertInstanceOf(Checkboxes::class, $input);
    }

    public function testOptions()
    {
        $input = Streams::make('testing.litmus')->fields->checkboxes->input();

        $this->assertEquals([
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
        ], $input->field->type()->options());
    }

    public function testHtmlAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->checkboxes->input();

        $this->assertStringContainsString('id="checkboxes-input"', $input->htmlAttributes());
    }
}
