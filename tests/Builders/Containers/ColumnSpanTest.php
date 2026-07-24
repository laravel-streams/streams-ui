<?php

namespace Streams\Ui\Tests\Builders\Containers;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Containers\Card;
use Streams\Ui\Builders\Containers\Grid;
use Streams\Ui\Builders\Containers\Container;

class ColumnSpanTest extends UiTestCase
{
    /** @test */
    public function it_renders_card_column_span_css_variables(): void
    {
        $html = Card::make('preview')
            ->columnSpan(2)
            ->toHtml();

        $this->assertStringContainsString('col-[--col-span-default]', $html);
        $this->assertStringContainsString('--col-span-default: span 2 / span 2', $html);
    }

    /** @test */
    public function it_renders_container_column_span_css_variables(): void
    {
        $html = Container::make('fields')
            ->columnSpan(1)
            ->toHtml();

        $this->assertStringContainsString('col-[--col-span-default]', $html);
        $this->assertStringContainsString('--col-span-default: span 1 / span 1', $html);
    }

    /** @test */
    public function it_does_not_emit_default_column_span_on_layout_grid(): void
    {
        $html = Grid::make('layout')
            ->columns(3)
            ->toHtml();

        $this->assertStringContainsString('grid-cols-3', $html);
        $this->assertStringContainsString('items-start', $html);
        $this->assertStringNotContainsString('col-[--col-span-default]', $html);
        $this->assertStringNotContainsString('--col-span-default:', $html);
    }

    /** @test */
    public function it_top_aligns_grid_children(): void
    {
        $html = Grid::make('form-fields-builder')
            ->columns(3)
            ->components([
                Container::make('fields')->columnSpan(1),
                Card::make('preview')->columnSpan(2),
            ])
            ->toHtml();

        $this->assertMatchesRegularExpression(
            '/class="[^"]*\bgrid\b[^"]*\bitems-start\b[^"]*\bgrid-cols-3\b/',
            $html,
        );
    }

    /** @test */
    public function it_emits_column_span_on_grid_when_explicitly_configured(): void
    {
        $html = Grid::make('nested')
            ->columns(2)
            ->columnSpan(2)
            ->toHtml();

        $this->assertStringContainsString('col-[--col-span-default]', $html);
        $this->assertStringContainsString('--col-span-default: span 2 / span 2', $html);
    }

    /** @test */
    public function it_keeps_child_spans_when_nested_in_a_layout_grid(): void
    {
        $html = Grid::make('form-fields-builder')
            ->columns(3)
            ->components([
                Container::make('fields')->columnSpan(1),
                Card::make('preview')->columnSpan(2),
            ])
            ->toHtml();

        $this->assertStringContainsString('grid-cols-3', $html);
        $this->assertStringContainsString('--col-span-default: span 1 / span 1', $html);
        $this->assertStringContainsString('--col-span-default: span 2 / span 2', $html);

        // Layout grid itself must not publish a default span that children could inherit.
        $this->assertDoesNotMatchRegularExpression(
            '/class="[^"]*grid gap-4[^"]*col-\[--col-span-default\]/',
            $html,
        );
    }

    /** @test */
    public function it_tracks_whether_column_span_was_configured(): void
    {
        $grid = Grid::make('layout')->columns(3);

        $this->assertFalse($grid->hasColumnSpan());

        $grid->columnSpan(2);

        $this->assertTrue($grid->hasColumnSpan());
        $this->assertSame(2, $grid->getColumnSpan('default'));
    }
}
