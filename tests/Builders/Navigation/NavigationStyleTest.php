<?php

namespace Streams\Ui\Tests\Builders\Navigation;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Navigation\Vertical;
use Streams\Ui\Builders\Navigation\Navigation;
use Streams\Ui\Builders\Navigation\NavigationItem;

class NavigationStyleTest extends UiTestCase
{
    /** @test */
    public function it_defaults_to_underline_style_with_full_width_faint_line(): void
    {
        $html = Navigation::make('tabs')
            ->items([
                NavigationItem::make('Team')
                    ->url('/team')
                    ->isActiveWhen(fn () => true),
                NavigationItem::make('Roles')
                    ->url('/roles'),
            ])
            ->toHtml();

        $this->assertSame('underline', Navigation::make()->getStyle());
        $this->assertStringContainsString('border-b border-gray-200', $html);
        $this->assertStringNotContainsString('_class=', $html);
        $this->assertStringContainsString('border-primary-500', $html);
        $this->assertStringContainsString('text-primary-600', $html);
    }

    /** @test */
    public function it_renders_simple_style_with_faint_line_and_no_active_underline_accent(): void
    {
        $html = Navigation::make('tabs')
            ->style('simple')
            ->activeColor('primary')
            ->items([
                NavigationItem::make('Team')
                    ->url('/team')
                    ->isActiveWhen(fn () => true),
                NavigationItem::make('Roles')
                    ->url('/roles'),
            ])
            ->toHtml();

        $this->assertStringContainsString('border-b border-gray-200', $html);
        $this->assertStringContainsString('text-primary-600', $html);
        $this->assertStringNotContainsString('border-primary-500', $html);
        $this->assertStringNotContainsString('border-b-2', $html);
    }

    /** @test */
    public function it_renders_pills_style_with_radius_outline_and_active_fill(): void
    {
        $html = Navigation::make('tabs')
            ->style('pills')
            ->activeColor('primary')
            ->borderRadius('full')
            ->outlined()
            ->items([
                NavigationItem::make('Members')
                    ->url('/members')
                    ->isActiveWhen(fn () => true),
                NavigationItem::make('Events')
                    ->url('/events'),
            ])
            ->toHtml();

        $this->assertStringContainsString('rounded-full', $html);
        $this->assertStringContainsString('border border-gray-200', $html);
        $this->assertStringContainsString('bg-primary-600', $html);
        $this->assertStringContainsString('text-white', $html);
    }

    /** @test */
    public function it_renders_bar_style_with_segmented_container_and_active_accent(): void
    {
        $html = Navigation::make('tabs')
            ->style('bar')
            ->activeColor('primary')
            ->borderRadius('md')
            ->items([
                NavigationItem::make('My Account')
                    ->url('/account'),
                NavigationItem::make('Team Members')
                    ->url('/team')
                    ->isActiveWhen(fn () => true),
            ])
            ->toHtml();

        $this->assertStringContainsString('divide-x divide-gray-200', $html);
        $this->assertStringContainsString('border border-gray-200', $html);
        $this->assertStringContainsString('rounded-md', $html);
        $this->assertStringContainsString('border-primary-500', $html);
        $this->assertStringContainsString('font-semibold', $html);
    }

    /** @test */
    public function it_renders_icons_with_configured_position_for_pills(): void
    {
        $html = Navigation::make('tabs')
            ->style('pills')
            ->items([
                NavigationItem::make('Members')
                    ->url('/members')
                    ->icon('/img/users.svg')
                    ->iconPosition('after')
                    ->isActiveWhen(fn () => true),
            ])
            ->toHtml();

        $this->assertStringContainsString('src="/img/users.svg"', $html);
        $this->assertMatchesRegularExpression(
            '/Members[\s\S]*src="\/img\/users\.svg"/',
            $html
        );
    }

    /** @test */
    public function it_renders_vertical_navigation_with_icons_badges_and_primary_active_color(): void
    {
        $html = Vertical::make('sidebar')
            ->items([
                NavigationItem::make('Dashboard')
                    ->url('/dashboard')
                    ->icon('/img/home.svg')
                    ->badge('5')
                    ->isActiveWhen(fn () => true),
                NavigationItem::make('Team')
                    ->url('/team')
                    ->icon('heroicon-o-users'),
            ])
            ->toHtml();

        $this->assertSame('vertical', Vertical::make()->getStyle());
        $this->assertStringContainsString('space-y-1', $html);
        $this->assertStringContainsString('bg-gray-50 text-primary-600', $html);
        $this->assertStringContainsString('src="/img/home.svg"', $html);
        $this->assertStringContainsString('Dashboard', $html);
        $this->assertStringContainsString('5', $html);
        $this->assertStringNotContainsString('aria-label="Select a tab"', $html);
    }

    /** @test */
    public function it_omits_hidden_items_and_disables_interaction_for_disabled_items(): void
    {
        $html = Navigation::make('tabs')
            ->style('underline')
            ->items([
                NavigationItem::make('Visible')
                    ->url('/visible')
                    ->isActiveWhen(fn () => true),
                NavigationItem::make('Hidden')
                    ->url('/hidden')
                    ->hidden(),
                NavigationItem::make('Disabled')
                    ->url('/disabled')
                    ->disabled(fn () => true),
            ])
            ->toHtml();

        $this->assertStringContainsString('Visible', $html);
        $this->assertStringNotContainsString('Hidden', $html);
        $this->assertStringContainsString('Disabled', $html);
        $this->assertStringContainsString('aria-disabled="true"', $html);
        $this->assertStringContainsString('pointer-events-none', $html);
        $this->assertStringNotContainsString('href="/hidden"', $html);
    }

    /** @test */
    public function it_supports_custom_active_color(): void
    {
        $html = Navigation::make('tabs')
            ->style('underline')
            ->activeColor('red')
            ->items([
                NavigationItem::make('Team')
                    ->url('/team')
                    ->isActiveWhen(fn () => true),
            ])
            ->toHtml();

        $this->assertStringContainsString('border-red-500', $html);
        $this->assertStringContainsString('text-red-600', $html);
    }
}
