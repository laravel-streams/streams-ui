<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\File;
use Streams\Core\Support\Facades\Streams;

class FileTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->file->input();

        $this->assertInstanceOf(File::class, $input);
    }

    public function testAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->file;
        $input = $field->input();

        $this->assertStringContainsString('type="file"', $input->htmlAttributes());
    }

    public function tearDown(): void
    {
        if (is_dir($dir = base_path('vendor/streams/ui/tests/data/uploads'))) {
            File::deleteDirectory($dir);
        }
    }
}
