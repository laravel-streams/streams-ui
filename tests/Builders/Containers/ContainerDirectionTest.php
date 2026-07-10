<?php

namespace Streams\Ui\Tests\Builders\Containers;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Containers\Container;

class ContainerDirectionTest extends UiTestCase
{
    /** @test */
    public function it_defaults_to_column_direction(): void
    {
        $container = Container::make('test');

        $this->assertSame('col', $container->getDirection());
        $this->assertTrue($container->isColumnDirection());

        $html = $container->toHtml();

        $this->assertStringContainsString('flex-col', $html);
        $this->assertStringNotContainsString('flex-row', $html);
    }

    /** @test */
    public function it_renders_column_direction_when_configured(): void
    {
        $html = Container::make('test')
            ->direction('col')
            ->toHtml();

        $this->assertStringContainsString('flex-col', $html);
        $this->assertStringNotContainsString('flex-row', $html);
    }

    /** @test */
    public function it_renders_row_direction_when_configured(): void
    {
        $html = Container::make('test')
            ->direction('row')
            ->toHtml();

        $this->assertStringContainsString('flex-row', $html);
        $this->assertStringNotContainsString('flex-col', $html);
    }

    /** @test */
    public function it_rejects_invalid_direction_values(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Direction must be 'row' or 'col'");

        Container::make('test')
            ->direction('column')
            ->getDirection();
    }
}
