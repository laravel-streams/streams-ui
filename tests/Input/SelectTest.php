<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Select;
use Streams\Core\Support\Facades\Streams;

class SelectTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testinitializePrototypeTrait()
    {
        $input = Streams::make('testing.litmus')->fields->select->input();

        $this->assertInstanceOf(Select::class, $input);
    }

    public function testOptions()
    {
        $input = Streams::make('testing.litmus')->fields->select->input();

        $this->assertEquals([
            'foo' => 'Foo',
            'bar' => 'Bar',
        ], $input->field->config['options']);
    }

    // public function testHtmlAttributes()
    // {
    //     $input = Streams::make('testing.litmus')->fields->select->input();

    //     $this->assertStringContainsString('type="date"', $input->htmlAttributes());
    //     $this->assertStringContainsString('min="2021-01-01"', $input->htmlAttributes());
    //     $this->assertStringContainsString('max="2121-01-01"', $input->htmlAttributes());
    // }
}
