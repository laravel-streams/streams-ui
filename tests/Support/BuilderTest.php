<?php

namespace Streams\Ui\Tests\Support;

use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;

class BuilderTest extends UiTestCase
{
    public function test_it_normalizes_stream_attribute()
    {
        $component = new Component([
            'stream' => 'films',
        ]);

        $this->assertInstanceOf(Stream::class, $component->stream);
    }

    public function test_it_normalizes_html_attributes()
    {
        $component = new Component(array_merge($attributes = [
            'href' => '#films',
            'url' => '#films',
            'target' => '#modal',
            'data-toggle' => 'modal',
        ], ['text' => 'Test']));

        $this->assertSame('Test', $component->text);
        $this->assertSame($attributes, $component->attributes);
    }
}
