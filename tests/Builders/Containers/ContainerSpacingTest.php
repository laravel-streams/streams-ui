<?php

namespace Streams\Ui\Tests\Builders\Containers;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Containers\Container;

class ContainerSpacingTest extends UiTestCase
{
    /** @test */
    public function it_defaults_to_s_spacing(): void
    {
        $container = Container::make('test');

        $this->assertSame('s', $container->getSpacing());

        $html = $container->toHtml();

        $this->assertStringContainsString('space-y-4', $html);
    }

    /** @test */
    public function it_maps_column_spacing_tokens_to_vertical_tailwind_classes_in_markup(): void
    {
        $cases = [
            'xs' => 'space-y-2',
            's' => 'space-y-4',
            'm' => 'space-y-6',
            'l' => 'space-y-8',
            'xl' => 'space-y-10',
            '2xl' => 'space-y-12',
        ];

        foreach ($cases as $token => $expectedClass) {
            $html = Container::make('test')
                ->direction('col')
                ->spacing($token)
                ->toHtml();

            $this->assertStringContainsString($expectedClass, $html);
        }
    }

    /** @test */
    public function it_maps_row_spacing_tokens_to_horizontal_tailwind_classes_in_markup(): void
    {
        $cases = [
            'xs' => 'space-x-2',
            's' => 'space-x-4',
            'm' => 'space-x-6',
            'l' => 'space-x-8',
            'xl' => 'space-x-10',
            '2xl' => 'space-x-12',
        ];

        foreach ($cases as $token => $expectedClass) {
            $html = Container::make('test')
                ->direction('row')
                ->spacing($token)
                ->toHtml();

            $this->assertStringContainsString($expectedClass, $html);
        }
    }

    /** @test */
    public function it_renders_spacing_classes_in_markup(): void
    {
        $html = Container::make('test')
            ->direction('col')
            ->spacing('xl')
            ->toHtml();

        $this->assertStringContainsString('space-y-10', $html);
        $this->assertStringNotContainsString('space-y-4', $html);
    }
}
