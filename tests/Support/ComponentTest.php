<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Button\Button;
use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\View;
use Streams\Ui\ControlPanel\ControlPanel;
use Streams\Core\Field\Decorator\StringDecorator;

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
        $component = new Button([
            'text' => 'Test Text',
        ]);

        $this->assertStringContainsString('Test Text', $component->render());
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

    public function test_it_returns_request_input()
    {
        $this->get('?custom_test_foo=bar');

        $component = new Button([
            'stream' => 'films',
            'options' => [
                'prefix' => 'custom_test_',
            ],
        ]);

        $this->assertSame('bar', $component->request('foo'));
    }

    public function test_it_returns_responses()
    {
        $this->get('');

        $component = new Button;

        $this->assertInstanceOf(
            \Symfony\Component\HttpFoundation\Response::class,
            $component->response()
        );
    }

    public function test_it_returns_post_responses()
    {
        $this->post('');

        $component = new Button;

        $this->assertTrue(is_string($component->response()));
    }

    public function test_it_returns_cp_responses()
    {
        View::share('cp', new ControlPanel());
        
        $this->get('');

        $component = new Button;

        $this->assertInstanceOf(
            \Symfony\Component\HttpFoundation\Response::class,
            $component->response()
        );
    }

    public function test_it_can_set_response_returned()
    {
        $response = $this->get('?custom_test_foo=bar');

        $component = new Button([
            'stream' => 'films',
            'text' => [
                'prefix' => 'custom_test_',
            ],
        ]);

        $component->response = $response;

        $this->assertInstanceOf(
            \Illuminate\Testing\TestResponse::class,
            $component->response()
        );
    }
    
    public function test_it_supports_macros()
    {
        Button::macro('testMacro', function() {
            $this->text = 'Test Text';
        });

        $component = new Button([
            'stream' => 'films',
        ]);

        $component->testMacro();
        
        $this->assertEquals('Test Text', $component->text);
    }

    public function test_it_automatically_decorates_attributes()
    {
        $component = new Button([
            'stream' => 'films',
            'foo' => 'Bar',
        ]);

        $this->assertInstanceOf(StringDecorator::class, $component->foo());
    }

    public function test_it_throws_exceptions_for_unmapped_methods()
    {
        $component = new Button([
            'stream' => 'films',
            'foo' => 'Bar',
        ]);

        $this->expectException(\Exception::class);

        $component->noSuchMethod();
    }
}

class CustomTestComponent extends Component
{
}
