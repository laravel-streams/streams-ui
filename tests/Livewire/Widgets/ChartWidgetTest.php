<?php

namespace Streams\Ui\Tests\Livewire\Widgets;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Livewire\Widgets\Widget;
use Streams\Ui\Livewire\Widgets\ChartWidget;

class ChartWidgetTest extends UiTestCase
{
    protected function getTestChartWidget(): ChartWidget
    {
        return new class extends ChartWidget
        {
            public function getData(): array
            {
                return [
                    'labels' => ['Jan', 'Feb', 'Mar'],
                    'datasets' => [
                        [
                            'label' => 'Sales',
                            'data' => [100, 200, 300],
                        ],
                    ],
                ];
            }
        };
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $widget = $this->getTestChartWidget();

        $this->assertInstanceOf(ChartWidget::class, $widget);
    }

    /** @test */
    public function it_extends_widget()
    {
        $widget = $this->getTestChartWidget();

        $this->assertInstanceOf(Widget::class, $widget);
    }

    /** @test */
    public function it_extends_livewire_component()
    {
        $widget = $this->getTestChartWidget();

        $this->assertInstanceOf(\Livewire\Component::class, $widget);
    }

    /** @test */
    public function it_has_default_view()
    {
        $reflection = new \ReflectionClass($this->getTestChartWidget());
        $property = $reflection->getProperty('view');
        $property->setAccessible(true);

        $this->assertEquals('ui::builders.chart', $property->getValue());
    }

    /** @test */
    public function it_has_default_type()
    {
        $widget = $this->getTestChartWidget();

        $this->assertEquals('line', $widget->getType());
    }

    /** @test */
    public function it_can_get_type()
    {
        $widget = new class extends ChartWidget
        {
            protected static string $type = 'bar';
        };

        $this->assertEquals('bar', $widget->getType());
    }

    /** @test */
    public function it_can_get_data()
    {
        $widget = $this->getTestChartWidget();

        $data = $widget->getData();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('labels', $data);
        $this->assertArrayHasKey('datasets', $data);
    }

    /** @test */
    public function it_returns_empty_array_for_default_data()
    {
        $widget = new class extends ChartWidget {};

        $this->assertEquals([], $widget->getData());
    }

    /** @test */
    public function it_can_get_options()
    {
        $widget = $this->getTestChartWidget();

        $options = $widget->getOptions();

        $this->assertIsArray($options);
    }

    /** @test */
    public function it_returns_empty_array_for_default_options()
    {
        $widget = $this->getTestChartWidget();

        $this->assertEquals([], $widget->getOptions());
    }

    /** @test */
    public function it_can_have_custom_options()
    {
        $widget = new class extends ChartWidget
        {
            protected static array $options = [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ];
        };

        $options = $widget->getOptions();

        $this->assertArrayHasKey('responsive', $options);
        $this->assertArrayHasKey('maintainAspectRatio', $options);
    }

    /** @test */
    public function it_can_get_callbacks()
    {
        $widget = $this->getTestChartWidget();

        $callbacks = $widget->getCallbacks();

        $this->assertIsArray($callbacks);
    }

    /** @test */
    public function it_returns_empty_array_for_default_callbacks()
    {
        $widget = $this->getTestChartWidget();

        $this->assertEquals([], $widget->getCallbacks());
    }

    /** @test */
    public function it_can_have_custom_callbacks()
    {
        $widget = new class extends ChartWidget
        {
            protected static array $callbacks = [
                'onClick' => 'function() {}',
            ];
        };

        $callbacks = $widget->getCallbacks();

        $this->assertArrayHasKey('onClick', $callbacks);
    }

    /** @test */
    public function it_can_get_functions()
    {
        $widget = $this->getTestChartWidget();

        $functions = $widget->getFunctions();

        $this->assertIsArray($functions);
    }

    /** @test */
    public function it_returns_empty_array_for_default_functions()
    {
        $widget = $this->getTestChartWidget();

        $this->assertEquals([], $widget->getFunctions());
    }

    /** @test */
    public function it_can_have_custom_functions()
    {
        $widget = new class extends ChartWidget
        {
            protected static array $functions = [
                'customFormatter' => 'function(value) { return value; }',
            ];
        };

        $functions = $widget->getFunctions();

        $this->assertArrayHasKey('customFormatter', $functions);
    }

    /** @test */
    public function it_uses_has_color_trait()
    {
        $widget = $this->getTestChartWidget();

        $this->assertTrue(method_exists($widget, 'color'));
        $this->assertTrue(method_exists($widget, 'getColor'));
    }

    /** @test */
    public function it_uses_has_heading_trait()
    {
        $widget = $this->getTestChartWidget();

        $this->assertTrue(method_exists($widget, 'heading'));
        $this->assertTrue(method_exists($widget, 'getHeading'));
    }

    /** @test */
    public function it_uses_has_components_trait()
    {
        $widget = $this->getTestChartWidget();

        $this->assertTrue(method_exists($widget, 'components'));
        $this->assertTrue(method_exists($widget, 'getComponents'));
    }

    /** @test */
    public function it_uses_has_description_trait()
    {
        $widget = $this->getTestChartWidget();

        $this->assertTrue(method_exists($widget, 'description'));
        $this->assertTrue(method_exists($widget, 'getDescription'));
    }

    /** @test */
    public function it_uses_can_poll_trait()
    {
        $widget = $this->getTestChartWidget();

        $this->assertTrue(method_exists($widget, 'getPollingInterval'));
    }

    /** @test */
    public function it_can_have_polling_interval()
    {
        $widget = new class extends ChartWidget
        {
            protected static ?string $pollingInterval = '5s';
        };

        $reflection = new \ReflectionClass($widget);
        $method = $reflection->getMethod('getPollingInterval');
        $method->setAccessible(true);

        $this->assertEquals('5s', $method->invoke($widget));
    }

    /** @test */
    public function it_returns_null_for_default_polling_interval()
    {
        $widget = $this->getTestChartWidget();

        $reflection = new \ReflectionClass($widget);
        $method = $reflection->getMethod('getPollingInterval');
        $method->setAccessible(true);

        $this->assertNull($method->invoke($widget));
    }

    /** @test */
    public function it_supports_different_chart_types()
    {
        $types = ['line', 'bar', 'pie', 'doughnut', 'radar', 'polarArea'];

        foreach ($types as $type) {
            $widget = new class($type) extends ChartWidget
            {
                public function __construct(string $type)
                {
                    self::$type = $type;
                }
            };

            $this->assertEquals($type, $widget->getType());
        }
    }
}
