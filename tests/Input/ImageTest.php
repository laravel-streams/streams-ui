<?php

namespace Streams\Ui\Tests\Input;

use Tests\TestCase;
use Streams\Ui\Input\Image;
use Illuminate\Support\Facades\File;
use Streams\Core\Support\Facades\Streams;

class ImageTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/litmus.json'));
    }
    
    public function tearDown(): void
    {
        if (is_dir($dir = base_path('vendor/streams/ui/tests/data/uploads'))) {
            File::deleteDirectory($dir);
        }
    }

    public function testInput()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $input = $entry->stream()->fields->image->input();

        $this->assertInstanceOf(Image::class, $input);
    }

    public function testHtmlAttributes()
    {
        $entry = Streams::repository('testing.litmus')->find('field_types');
        $field = $entry->stream()->fields->image;
        $input = $field->input();

        $this->assertStringContainsString('type="file"', $input->htmlAttributes());
    }
}
