<?php

namespace Streams\Ui\Tests\Support;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Support\Element;
use Streams\Ui\Tests\UiTestCase;

class ElementTest extends UiTestCase
{
    public function test_it_is_arrayable()
    {
        $this->assertIsArray((new Element([
            'tile' => 'Films',
        ]))->toArray());
    }

    public function test_it_is_jsonable()
    {
        $this->assertJson((new Element([
            'tile' => 'Films',
        ]))->toJson());
    }

    public function test_it_casts_to_string_as_json()
    {
        $this->assertSame('', (string) new Element([
            'tile' => 'Films',
        ]));
    }

    public function test_it_converts_text_stream_values()
    {
        $component = new Element([
            'stream' => 'films',
        ]);

        $this->assertInstanceOf(Stream::class, $component->stream);
    }

    public function test_it_returns_class_attribute_as_array()
    {
        $component = new Element([
            'classes' => [
                'original',
            ],
        ]);

        $this->assertSame([
            'original',
            'extra',
        ], $component->class('extra'));
    }

    public function test_it_returns_attributes_as_array()
    {
        $component = new Element([
            'attributes' => [
                'data-foo' => 'bar',
            ],
            'classes' => [
                'original',
            ],
        ]);

        $this->assertSame([
            'class' => [
                'original',
            ],
            'data-foo' => 'bar',
        ], $component->attributes());
    }

    public function test_it_returns_html_attributes_as_string()
    {
        $component = new Element([
            'attributes' => [
                'data-foo' => 'bar',
            ],
            'classes' => [
                'original',
            ],
        ]);

        $this->assertSame(' class="original" data-foo="bar"', $component->htmlAttributes());
    }

    public function test_it_renders_its_template()
    {
        $component = new Element([
            'template' => 'ui::support/element',
        ]);

        $this->assertSame("Foo Bar\n", $component->render());
    }

    public function test_it_returns_its_api_url()
    {
        $element = new CustomTestElement([
            'stream' => 'films',
            'component' => 'custom_test',
        ]);

        $this->assertSame(url('cp/ui/films/custom_test'), $element->url());
    }

    public function test_it_prefixes_strings()
    {
        $element = new Element([
            'options' => [
                'prefix' => 'custom_test_',
            ],
        ]);

        $this->assertSame('custom_test_foo', $element->prefix('foo'));
    }
}

class CustomTestElement extends Element
{
}
