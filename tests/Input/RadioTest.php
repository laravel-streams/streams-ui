<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Radio;
use Streams\Core\Support\Facades\Streams;

class RadioTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->radio->input();

        $this->assertInstanceOf(Radio::class, $input);
    }

    public function testDisplay()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->radio;
        $input = $field->input();

        $input->value = 'bar';

        $this->assertStringContainsString('value="foo"', (string) $input->render());
        $this->assertStringContainsString('value="bar" type="radio" id="radio-input" checked', (string) $input->render());
    }

    public function testHtmlAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->radio;
        $input = $field->input();

        $this->assertStringContainsString('type="radio"', $input->htmlAttributes());
    }
}
