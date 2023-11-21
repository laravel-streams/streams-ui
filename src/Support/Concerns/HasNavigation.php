<?php

namespace Streams\Ui\Support\Concerns;

use Streams\Ui\Panels\Panel;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Navigation\NavigationItem;

trait HasNavigation
{
    protected static bool $registerNavigation = true;

    protected static ?string $navigationLabel = null;

    protected static ?string $navigationIcon = null;

    protected static ?string $activeNavigationIcon = null;

    protected static ?string $navigationGroup = null;

    protected static ?int $navigationSort = null;

    public static function registerNavigationItems(Panel $panel): void
    {
        if (!static::shouldRegisterNavigation()) {
            return;
        }

        $panel->navigationItems(static::getNavigationItems());
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return static::$registerNavigation;
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make(static::getNavigationLabel())
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(fn (): bool => request()->routeIs(static::getRouteName()))
                ->sort(static::getNavigationSort())
                ->badge(static::getNavigationBadge(), color: static::getNavigationBadgeColor())
                ->url(static::getNavigationUrl()),
        ];
    }

    protected static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?: static::getTitle();
    }

    protected static function getNavigationIcon(): ?string
    {
        return static::$navigationIcon;
    }

    protected static function getActiveNavigationIcon(): ?string
    {
        return static::$activeNavigationIcon ?? static::getNavigationIcon();
    }

    protected static function getNavigationBadge(): ?string
    {
        return null;
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return null;
    }

    protected static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup;
    }

    protected static function getNavigationSort(): ?int
    {
        return static::$navigationSort;
    }

    protected static function getNavigationUrl(): ?string
    {
        return static::getUrl();
    }

    public static function getRouteName(?string $panel = null): string
    {
        $panel ??= UI::currentPanel()->getId();

        return (string) str(static::getSlug())
            ->replace('/', '.')
            ->prepend("streams.ui.{$panel}.");
    }
}
