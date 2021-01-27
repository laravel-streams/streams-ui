<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Relationship;
use Streams\Core\Support\Facades\Streams;

class RelationshipTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/ui/tests/examples.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->relationship->input();

        $this->assertInstanceOf(Relationship::class, $input);
    }

    public function testOptions()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->relationship;
        $input = $field->input();

        $this->assertEquals([
            'first' => 'First Example',
        ], $input->options());
    }
}
