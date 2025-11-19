<?php

namespace Streams\Ui\Tests\Livewire\Widgets;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Livewire\Widgets\Widget;
use Streams\Ui\Livewire\Widgets\StatsWidget;
use Streams\Ui\Livewire\Widgets\Stats\Stat;

class StatsWidgetTest extends UiTestCase
{
    protected function getTestStatsWidget(): StatsWidget
    {
        return new class extends StatsWidget
        {
            public function getStats(): array
            {
                return [
                    Stat::make('Total Users', '1,234'),
                    Stat::make('Revenue', '$45,678'),
                ];
            }
        };
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $widget = $this->getTestStatsWidget();

        $this->assertInstanceOf(StatsWidget::class, $widget);
    }

    /** @test */
    public function it_extends_widget()
    {
        $widget = $this->getTestStatsWidget();

        $this->assertInstanceOf(Widget::class, $widget);
    }

    /** @test */
    public function it_extends_livewire_component()
    {
        $widget = $this->getTestStatsWidget();

        $this->assertInstanceOf(\Livewire\Component::class, $widget);
    }

    /** @test */
    public function it_has_default_view()
    {
        $reflection = new \ReflectionClass($this->getTestStatsWidget());
        $property = $reflection->getProperty('view');
        $property->setAccessible(true);

        $this->assertEquals('ui::builders.stats', $property->getValue());
    }

    /** @test */
    public function it_can_get_stats()
    {
        $widget = $this->getTestStatsWidget();

        $stats = $widget->getStats();

        $this->assertIsArray($stats);
        $this->assertCount(2, $stats);
    }

    /** @test */
    public function it_returns_empty_array_for_default_stats()
    {
        $widget = new class extends StatsWidget
        {
        };

        $this->assertEquals([], $widget->getStats());
    }

    /** @test */
    public function it_stats_are_stat_instances()
    {
        $widget = $this->getTestStatsWidget();

        $stats = $widget->getStats();

        foreach ($stats as $stat) {
            $this->assertInstanceOf(Stat::class, $stat);
        }
    }

    /** @test */
    public function it_uses_can_poll_trait()
    {
        $widget = $this->getTestStatsWidget();

        $this->assertTrue(method_exists($widget, 'getPollingInterval'));
    }

    /** @test */
    public function it_can_have_polling_interval()
    {
        $widget = new class extends StatsWidget
        {
            protected static ?string $pollingInterval = '10s';
        };

        $reflection = new \ReflectionClass($widget);
        $method = $reflection->getMethod('getPollingInterval');
        $method->setAccessible(true);

        $this->assertEquals('10s', $method->invoke($widget));
    }

    /** @test */
    public function it_returns_null_for_default_polling_interval()
    {
        $widget = $this->getTestStatsWidget();

        $reflection = new \ReflectionClass($widget);
        $method = $reflection->getMethod('getPollingInterval');
        $method->setAccessible(true);

        $this->assertNull($method->invoke($widget));
    }
}
