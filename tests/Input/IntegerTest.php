<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Integer;
use Streams\Core\Support\Facades\Streams;

class IntegerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->integer->input();

        $this->assertInstanceOf(Integer::class, $input);
    }

    public function testAttributes()
    {
        $input = Streams::make('testing.litmus')->fields->integer->input();

        $this->assertStringContainsString('type="number"', $input->htmlAttributes());
        $this->assertStringContainsString('min="-1"', $input->htmlAttributes());
        $this->assertStringContainsString('max="1"', $input->htmlAttributes());
    }
}
