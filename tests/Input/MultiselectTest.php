<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Multiselect;
use Streams\Core\Support\Facades\Streams;

class MultiselectTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInitializePrototype()
    {
        $input = Streams::make('testing.litmus')->fields->multiselect->input();

        $this->assertInstanceOf(Multiselect::class, $input);
    }

    public function testOptions()
    {
        $input = Streams::make('testing.litmus')->fields->multiselect->input();

        $this->assertEquals([
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
        ], $input->field->config['options']);
    }

    // public function testHtmlAttributes()
    // {
    //     $input = Streams::make('testing.litmus')->fields->date->input();

    //     $this->assertStringContainsString('type="date"', $input->htmlAttributes());
    //     $this->assertStringContainsString('min="2021-01-01"', $input->htmlAttributes());
    //     $this->assertStringContainsString('max="2121-01-01"', $input->htmlAttributes());
    // }
}
