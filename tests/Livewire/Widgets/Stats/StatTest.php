<?php

namespace Streams\Ui\Tests\Livewire\Widgets\Stats;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Livewire\Widgets\Stats\Stat;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class StatTest extends UiTestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $stat = new Stat('Label', 'Value');

        $this->assertInstanceOf(Stat::class, $stat);
    }

    /** @test */
    public function it_extends_view_component()
    {
        $stat = new Stat('Label', 'Value');

        $this->assertInstanceOf(\Illuminate\View\Component::class, $stat);
    }

    /** @test */
    public function it_implements_htmlable()
    {
        $stat = new Stat('Label', 'Value');

        $this->assertInstanceOf(Htmlable::class, $stat);
    }

    /** @test */
    public function it_can_be_made_with_static_method()
    {
        $stat = Stat::make('Users', '1,234');

        $this->assertInstanceOf(Stat::class, $stat);
    }

    /** @test */
    public function it_sets_label_on_construction()
    {
        $stat = new Stat('Test Label', '100');

        $this->assertEquals('Test Label', $stat->getLabel());
    }

    /** @test */
    public function it_sets_value_on_construction()
    {
        $stat = new Stat('Label', '100');

        $this->assertEquals('100', $stat->getValue());
    }

    /** @test */
    public function it_uses_can_span_columns_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'columnSpan'));
        $this->assertTrue(method_exists($stat, 'getColumnSpan'));
    }

    /** @test */
    public function it_uses_evaluates_closures_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'evaluate'));
    }

    /** @test */
    public function it_uses_has_description_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'description'));
        $this->assertTrue(method_exists($stat, 'getDescription'));
    }

    /** @test */
    public function it_uses_has_html_attributes_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'htmlAttributes'));
        $this->assertTrue(method_exists($stat, 'getHtmlAttributes'));
    }

    /** @test */
    public function it_uses_has_id_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'id'));
        $this->assertTrue(method_exists($stat, 'getId'));
    }

    /** @test */
    public function it_uses_has_label_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'label'));
        $this->assertTrue(method_exists($stat, 'getLabel'));
    }

    /** @test */
    public function it_uses_has_url_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'url'));
        $this->assertTrue(method_exists($stat, 'getUrl'));
    }

    /** @test */
    public function it_uses_has_value_trait()
    {
        $stat = Stat::make('Label', 'Value');

        $this->assertTrue(method_exists($stat, 'value'));
        $this->assertTrue(method_exists($stat, 'getValue'));
    }

    /** @test */
    public function it_can_set_description()
    {
        $stat = Stat::make('Label', 'Value')
            ->description('Test description');

        $this->assertEquals('Test description', $stat->getDescription());
    }

    /** @test */
    public function it_can_set_url()
    {
        $stat = Stat::make('Label', 'Value')
            ->url('/test-url');

        $this->assertEquals('/test-url', $stat->getUrl());
    }

    /** @test */
    public function it_can_set_column_span()
    {
        $stat = Stat::make('Label', 'Value')
            ->columnSpan(2);

        $columnSpan = $stat->getColumnSpan();
        
        $this->assertNotNull($columnSpan);
    }

    /** @test */
    public function it_can_render()
    {
        $stat = Stat::make('Label', 'Value');

        $result = $stat->render();

        $this->assertInstanceOf(View::class, $result);
    }

    /** @test */
    public function it_can_convert_to_html()
    {
        $stat = Stat::make('Label', 'Value');

        $html = $stat->toHtml();

        $this->assertIsString($html);
    }

    /** @test */
    public function it_accepts_various_value_types()
    {
        $stat1 = Stat::make('Integer', 123);
        $stat2 = Stat::make('Float', 45.67);
        $stat3 = Stat::make('String', 'Test');
        $stat4 = Stat::make('Null', null);

        $this->assertEquals(123, $stat1->getValue());
        $this->assertEquals(45.67, $stat2->getValue());
        $this->assertEquals('Test', $stat3->getValue());
        $this->assertNull($stat4->getValue());
    }

    /** @test */
    public function it_supports_fluent_interface()
    {
        $stat = Stat::make('Label', 'Value')
            ->description('Description')
            ->url('/url')
            ->columnSpan(2);

        $this->assertInstanceOf(Stat::class, $stat);
        $this->assertEquals('Description', $stat->getDescription());
        $this->assertEquals('/url', $stat->getUrl());
        $this->assertNotNull($stat->getColumnSpan());
    }

    /** @test */
    public function it_can_update_label_after_construction()
    {
        $stat = Stat::make('Original', 'Value')
            ->label('Updated');

        $this->assertEquals('Updated', $stat->getLabel());
    }

    /** @test */
    public function it_can_update_value_after_construction()
    {
        $stat = Stat::make('Label', 'Original')
            ->value('Updated');

        $this->assertEquals('Updated', $stat->getValue());
    }
}
