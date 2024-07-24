<?php

namespace Streams\Ui\Resources\Concerns;

use Streams\Ui\Navigation\NavigationGroup;

trait HasNavigationGroups
{
    protected static array | \Closure | null $navigationGroups = [];

    public static function navigationGroups(array | \Closure | null $navigationGroups)
    {
        self::$navigationGroups = $navigationGroups;
    }
    
    public static function getNavigationGroups(): array
    {
        return self::$navigationGroups;
    }

    // This was me - collides with vendor/streams/ui/src/Traits/HasNavigationGroups.php
    // public static function getNavigationGroup($label = null): ?NavigationGroup
    // {
    //     $groups = static::getNavigationGroups();

    //     return static::once(__METHOD__ . "({$label})", function() use ($groups, $label) {

    //         if (!$label && $groups) {
    //             return reset($groups);
    //         }

    //         return isset($groups[$label]) ? $groups[$label] : null;
    //     });

    // }
}
