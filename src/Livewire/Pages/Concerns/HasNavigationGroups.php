<?php

namespace Streams\Ui\Livewire\Pages\Concerns;

trait HasNavigationGroups
{
    protected static array|\Closure|null $navigationGroups = [];

    public static function navigationGroups(array|\Closure|null $navigationGroups)
    {
        self::$navigationGroups = $navigationGroups;
    }

    public static function getNavigationGroups(): array
    {
        return [];
    }
}
