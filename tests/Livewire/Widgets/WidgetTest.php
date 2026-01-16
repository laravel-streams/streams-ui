<?php

namespace Streams\Ui\Tests\Livewire\Widgets;

use Streams\Ui\Tests\UiTestCase;
use Illuminate\Contracts\View\View;
use Streams\Ui\Livewire\Widgets\Widget;

class WidgetTest extends UiTestCase
{
    protected function getTestWidget(): Widget
    {
        return new class extends Widget
        {
            protected static string $view = 'test-widget-view';

            public function test_public_method(): string
            {
                return 'test';
            }
        };
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $widget = $this->getTestWidget();

        $this->assertInstanceOf(Widget::class, $widget);
    }

    /** @test */
    public function it_extends_livewire_component()
    {
        $widget = $this->getTestWidget();

        $this->assertInstanceOf(\Livewire\Component::class, $widget);
    }

    /** @test */
    public function it_uses_can_span_columns_trait()
    {
        $widget = $this->getTestWidget();

        $this->assertTrue(method_exists($widget, 'columnSpan'));
        $this->assertTrue(method_exists($widget, 'getColumnSpan'));
    }

    /** @test */
    public function it_uses_evaluates_closures_trait()
    {
        $widget = $this->getTestWidget();

        $this->assertTrue(method_exists($widget, 'evaluate'));
    }

    /** @test */
    public function it_uses_fires_callbacks_trait()
    {
        $widget = $this->getTestWidget();

        $this->assertTrue(method_exists($widget, 'fire'));
        $this->assertTrue(method_exists($widget, 'addCallback'));
        $this->assertTrue(method_exists($widget, 'hasCallback'));
    }

    /** @test */
    public function it_uses_has_memory_trait()
    {
        $widget = $this->getTestWidget();

        $this->assertTrue(method_exists($widget, 'once'));
        $this->assertTrue(method_exists($widget, 'remember'));
    }

    /** @test */
    public function it_can_render()
    {
        $widget = $this->getTestWidget();

        $this->app['view']->addLocation(__DIR__);
        file_put_contents(__DIR__.'/test-widget-view.blade.php', '<div>Test Widget</div>');

        $result = $widget->render();

        $this->assertInstanceOf(View::class, $result);

        @unlink(__DIR__.'/test-widget-view.blade.php');
    }

    /** @test */
    public function it_returns_view_data()
    {
        $widget = $this->getTestWidget();

        $reflection = new \ReflectionClass($widget);
        $method = $reflection->getMethod('getViewData');
        $method->setAccessible(true);

        $data = $method->invoke($widget);

        $this->assertIsArray($data);
    }

    /** @test */
    public function it_returns_empty_array_for_default_view_data()
    {
        $widget = $this->getTestWidget();

        $reflection = new \ReflectionClass($widget);
        $method = $reflection->getMethod('getViewData');
        $method->setAccessible(true);

        $data = $method->invoke($widget);

        $this->assertEquals([], $data);
    }

    /** @test */
    public function it_can_override_view_data()
    {
        $widget = new class extends Widget
        {
            protected static string $view = 'test-view';

            protected function getViewData(): array
            {
                return ['key' => 'value'];
            }
        };

        $reflection = new \ReflectionClass($widget);
        $method = $reflection->getMethod('getViewData');
        $method->setAccessible(true);

        $data = $method->invoke($widget);

        $this->assertEquals(['key' => 'value'], $data);
    }

    /** @test */
    public function it_is_abstract_class()
    {
        $reflection = new \ReflectionClass(Widget::class);

        $this->assertTrue($reflection->isAbstract());
    }

    /** @test */
    public function it_requires_view_property()
    {
        $widget = $this->getTestWidget();

        $reflection = new \ReflectionClass($widget);
        $property = $reflection->getProperty('view');
        $property->setAccessible(true);

        $this->assertEquals('test-widget-view', $property->getValue());
    }

    /** @test */
    public function it_can_be_extended()
    {
        $customWidget = new class extends Widget
        {
            protected static string $view = 'custom-view';

            public function customMethod(): string
            {
                return 'custom';
            }
        };

        $this->assertEquals('custom', $customWidget->customMethod());
    }
}
