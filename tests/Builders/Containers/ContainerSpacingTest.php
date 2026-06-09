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
    public function it_maps_spacing_tokens_to_tailwind_classes_in_markup(): void
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
                ->spacing($token)
                ->toHtml();

            $this->assertStringContainsString($expectedClass, $html);
        }
    }

    /** @test */
    public function it_renders_spacing_classes_in_markup(): void
    {
        $html = Container::make('test')
            ->spacing('xl')
            ->toHtml();

        $this->assertStringContainsString('space-y-10', $html);
        $this->assertStringNotContainsString('space-y-4', $html);
    }
}
