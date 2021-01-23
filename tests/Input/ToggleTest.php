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

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->toggle->input();

        $this->assertInstanceOf(Toggle::class, $input);
    }

    public function testAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->toggle;
        $input = $field->input();

        $this->assertStringContainsString('type="checkbox"', $input->htmlAttributes());
    }
}
