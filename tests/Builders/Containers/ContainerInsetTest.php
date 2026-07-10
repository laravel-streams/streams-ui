<?php

namespace Streams\Ui\Tests\Builders\Containers;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Containers\Card;
use Streams\Ui\Builders\Containers\Section;
use Streams\Ui\Builders\Containers\Container;

class ContainerInsetTest extends UiTestCase
{
    /** @test */
    public function it_has_no_inset_by_default_on_container(): void
    {
        $container = Container::make('test');

        $this->assertNull($container->getInset());

        $html = $container->toHtml();

        $this->assertStringNotContainsString('p-6', $html);
        $this->assertStringNotContainsString('p-0', $html);
    }

    /** @test */
    public function it_maps_inset_tokens_to_tailwind_padding_classes_on_container(): void
    {
        $cases = [
            'xs' => 'p-2',
            's' => 'p-4',
            'm' => 'p-6',
            'l' => 'p-8',
            'xl' => 'p-10',
            '2xl' => 'p-12',
        ];

        foreach ($cases as $token => $expectedClass) {
            $html = Container::make('test')
                ->inset($token)
                ->toHtml();

            $this->assertStringContainsString($expectedClass, $html);
        }
    }

    /** @test */
    public function it_treats_true_inset_as_medium_padding(): void
    {
        $html = Container::make('test')
            ->inset(true)
            ->toHtml();

        $this->assertStringContainsString('p-6', $html);
    }

    /** @test */
    public function it_renders_zero_padding_when_inset_is_disabled(): void
    {
        $html = Container::make('test')
            ->inset(false)
            ->toHtml();

        $this->assertStringContainsString('p-0', $html);
    }

    /** @test */
    public function it_defaults_section_content_inset_to_medium_when_unset(): void
    {
        $html = Section::make('test')
            ->components([
                Container::make('inner'),
            ])
            ->toHtml();

        $this->assertStringContainsString('p-6', $html);
    }

    /** @test */
    public function it_applies_custom_inset_to_section_content(): void
    {
        $html = Section::make('test')
            ->inset('l')
            ->components([
                Container::make('inner'),
            ])
            ->toHtml();

        $this->assertStringContainsString('p-8', $html);
        $this->assertStringNotContainsString('p-6', $html);
    }

    /** @test */
    public function it_defaults_card_heading_and_content_inset_when_unset(): void
    {
        $html = Card::make('test')
            ->heading('Card')
            ->components([
                Container::make('inner'),
            ])
            ->toHtml();

        $this->assertStringContainsString('px-6', $html);
        $this->assertStringContainsString('py-4', $html);
        $this->assertStringContainsString('p-6', $html);
    }

    /** @test */
    public function it_applies_custom_inset_to_card_heading_and_content(): void
    {
        $html = Card::make('test')
            ->heading('Card')
            ->inset('s')
            ->components([
                Container::make('inner'),
            ])
            ->toHtml();

        $this->assertStringContainsString('px-4', $html);
        $this->assertStringContainsString('py-4', $html);
        $this->assertStringContainsString('p-4', $html);
        $this->assertStringNotContainsString('p-6', $html);
    }
}
