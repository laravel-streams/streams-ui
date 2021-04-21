<?php

namespace Streams\Ui\Tests\Support;

use Tests\TestCase;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Streams\Core\Support\Facades\Streams;

class ComponentTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/examples.json'));
    }

    public function testUrl()
    {
        $component = new TestComponent();

        $this->assertNull($component->url());

        $component = new TestComponent([
            'stream' => Streams::make('testing.examples'),
        ]);

        $this->assertEquals(
            URL::cp('ui/testing.examples/input/example'),
            $component->url()
        );
    }

    public function testClass()
    {
        $component = new TestComponent([
            'classes' => [
                'test',
                'foo',
            ],
        ]);

        $this->assertStringContainsString('class="test foo"', (string) $component->render());

        $this->assertStringContainsString('test foo', $component->class(['foo']));
        $this->assertStringContainsString('test foo bar', $component->class('foo bar'));
    }

    public function testHtmlAttributes()
    {
        $component = new TestComponent([
            'attributes' => [
                'data-example' => 'test',
            ],
        ]);

        $this->assertStringContainsString('class="test"', $component->htmlAttributes());
        $this->assertStringContainsString('data-example="test"', $component->htmlAttributes());
        $this->assertStringContainsString('class="test foo"', $component->htmlAttributes(['class' => 'foo']));
    }

    public function testPrefix()
    {
        $component = new TestComponent();

        $this->assertEquals('example_test', $component->prefix('test'));
    }

    public function testArrayable()
    {
        $component = new TestComponent();

        $this->assertEquals([
            'handle' => 'example',
            'template' => 'ui::tests/component',
            'component' => 'input',
            'classes' => ['test'],
            'attributes' => [],
            'options' => [
                'prefix' => 'example_',
            ],
            'data' => new Collection(),
        ], $component->toArray());
    }

    public function testJsonable()
    {
        $component = new TestComponent();

        $this->assertStringContainsString('"handle":"example"', $component->toJson());
    }
    
    public function testToString()
    {
        $component = new TestComponent();

        $this->assertStringContainsString('class="test"', (string) $component);
    }
}

class TestComponent extends Component
{
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'handle' => 'example',
            'template' => 'ui::tests/component',
            'component' => 'input',
            'classes' => ['test'],
            'attributes' => [],
            'options' => [
                'prefix' => 'example_',
            ],
            'data' => new Collection(),
        ], $attributes));
    }
}
