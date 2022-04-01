<?php

namespace Streams\Ui\Tests\Support;

use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Streams\Core\Field\Decorator\StringDecorator;
use Streams\Ui\Components\Button;

class ComponentTest extends UiTestCase
{
    public function test_it_is_arrayable()
    {
        $this->assertIsArray((new ComponentTestComponent([
            'tile' => 'Films',
        ]))->toArray());
    }

    public function test_it_is_jsonable()
    {
        $this->assertJson((new ComponentTestComponent([
            'tile' => 'Films',
        ]))->toJson());
    }

    public function test_it_casts_to_string_as_json()
    {
        $this->assertSame('', (string) new ComponentTestComponent([
            'tile' => 'Films',
        ]));
    }

    public function test_it_converts_text_stream_values()
    {
        $component = new ComponentTestComponent([
            'stream' => 'films',
        ]);

        $this->assertInstanceOf(Stream::class, $component->stream);
    }

    public function test_it_returns_class_attribute_as_array()
    {
        $component = new ComponentTestComponent([
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
        $component = new ComponentTestComponent([
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
        ], $component->attributes()->all());
    }

    public function test_it_returns_html_attributes_as_string()
    {
        $component = new ComponentTestComponent([
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
        $component = new ComponentTestComponent([
            'text' => 'Test Text',
        ]);

        $this->assertStringContainsString('Test Text', $component->render());
    }

    public function test_it_returns_its_api_url()
    {
        $component = new ComponentTestComponent([
            'stream' => 'films',
            'component' => 'custom_test',
        ]);

        $this->assertSame(url('cp/ui/films/custom_test'), $component->url());
    }

    public function test_it_prefixes_strings()
    {
        $component = new ComponentTestComponent([
            'config' => [
                'prefix' => 'custom_test_',
            ],
        ]);

        $this->assertSame('custom_test_foo', $component->prefix('foo'));
    }

    public function test_it_returns_request_input()
    {
        $this->get('?custom_test_foo=bar');

        $component = new ComponentTestComponent([
            'stream' => 'films',
            'config' => [
                'prefix' => 'custom_test_',
            ],
        ]);

        $this->assertSame('bar', $component->request('foo'));
    }

    public function test_it_returns_responses()
    {
        $this->get('');

        $component = new ComponentTestComponent;

        $this->assertInstanceOf(
            \Symfony\Component\HttpFoundation\Response::class,
            $component->response()
        );
    }

    // public function test_it_returns_post_responses()
    // {
    //     $this->post('');

    //     $component = new ComponentTestComponent;

    //     $this->assertInstanceOf(
    //         \Symfony\Component\HttpFoundation\Response::class,
    //         $component->response()
    //     );
    // }

    // public function test_it_returns_cp_responses()
    // {
    //     View::share('cp', new ControlPanel());
        
    //     $this->get('');

    //     $component = new ComponentTestComponent;

    //     $this->assertInstanceOf(
    //         \Symfony\Component\HttpFoundation\Response::class,
    //         $component->cp()
    //     );

    //     $this->assertInstanceOf(
    //         \Symfony\Component\HttpFoundation\Response::class,
    //         $component->response()
    //     );
    // }

    public function test_it_can_set_response_returned()
    {
        $response = $this->get('?custom_test_foo=bar');

        $component = new ComponentTestComponent([
            'stream' => 'films',
            'config' => [
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
        ComponentTestComponent::macro('testMacro', function() {
            $this->text = 'Test Text';
        });

        $component = new ComponentTestComponent([
            'stream' => 'films',
        ]);

        $component->testMacro();
        
        $this->assertEquals('Test Text', $component->text);
    }

    public function test_it_automatically_decorates_attributes()
    {
        $component = new ComponentTestComponent([
            'stream' => 'films',
            'foo' => 'Bar',
        ]);

        $this->assertInstanceOf(StringDecorator::class, $component->foo());
    }

    public function test_it_throws_exceptions_for_unmapped_methods()
    {
        $component = new ComponentTestComponent([
            'stream' => 'films',
            'foo' => 'Bar',
        ]);

        $this->expectException(\Exception::class);

        $component->noSuchMethod();
    }
}

class ComponentTestComponent extends Component
{

}
