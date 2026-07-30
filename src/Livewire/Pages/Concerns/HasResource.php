<?php

namespace Streams\Ui\Livewire\Pages\Concerns;

use LogicException;

trait HasResource
{
    protected static string $resource;

    public static function hasResource(): bool
    {
        return isset(static::$resource);
    }

    public static function getResource(): string
    {
        return static::$resource;
    }

    public static function getResourcePageName(): string
    {
        foreach (static::getResource()::getPages() as $name => $pageRouter) {
            if ($pageRouter->getPage() === static::class) {
                return $name;
            }
        }

        throw new LogicException(
            'Page ['.static::class.'] is not registered on resource ['.static::getResource().'].'
        );
    }
}
