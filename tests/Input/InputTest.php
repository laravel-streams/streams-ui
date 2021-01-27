<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Input;
use Streams\Core\Support\Facades\Streams;

class InputTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->text->input();

        $this->assertInstanceOf(Input::class, $input);
    }

    public function testDislpay()
    {
        $input = Streams::make('testing.litmus')->fields->text->input();

        $this->assertEquals('text', $input->name());
        
        $input->prefix = 'example_';

        $this->assertEquals('example_text', $input->name());

        $this->assertEquals('Text', $input->label());
    }

    public function testAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->text;
        $input = $field->input();

        $this->assertStringContainsString('type="text"', $input->htmlAttributes());
        $this->assertStringContainsString('required', $input->htmlAttributes());
        $this->assertStringContainsString('disabled', $input->htmlAttributes());
        $this->assertStringContainsString('id="' . $input->name() . '-input"', $input->htmlAttributes());
    }
}
