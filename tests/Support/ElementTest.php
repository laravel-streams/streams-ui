<?php

namespace Streams\Ui\Tests\Support;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Support\Component;
use Streams\Ui\Tests\UiTestCase;

class ComponentTest extends UiTestCase
{
    public function test_it_is_arrayable()
    {
        $this->assertIsArray((new Component([
            'tile' => 'Films',
        ]))->toArray());
    }

    public function test_it_is_jsonable()
    {
        $this->assertJson((new Component([
            'tile' => 'Films',
        ]))->toJson());
    }

    public function test_it_casts_to_string_as_json()
    {
        $this->assertSame('', (string) new Component([
            'tile' => 'Films',
        ]));
    }

    public function test_it_converts_text_stream_values()
    {
        $component = new Component([
            'stream' => 'films',
        ]);

        $this->assertInstanceOf(Stream::class, $component->stream);
    }

    public function test_it_returns_class_attribute_as_array()
    {
        $component = new Component([
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
        $component = new Component([
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
        $component = new Component([
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
        $component = new Component([
            'template' => 'ui::support/component',
        ]);

        $this->assertSame("Foo Bar\n", $component->render());
    }

    public function test_it_returns_its_api_url()
    {
        $component = new CustomTestComponent([
            'stream' => 'films',
            'component' => 'custom_test',
        ]);

        $this->assertSame(url('cp/ui/films/custom_test'), $component->url());
    }

    public function test_it_prefixes_strings()
    {
        $component = new Component([
            'options' => [
                'prefix' => 'custom_test_',
            ],
        ]);

        $this->assertSame('custom_test_foo', $component->prefix('foo'));
    }
}

class CustomTestComponent extends Component
{
}
