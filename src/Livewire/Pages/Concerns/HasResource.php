<?php

namespace Streams\Ui\Livewire\Pages\Concerns;

use LogicException;
use Livewire\Attributes\Locked;
use Streams\Ui\Resources\Resource;

trait HasResource
{
    protected static string $resource;

    /**
     * Resource classes resolved for generic pages, keyed by page class.
     *
     * @var array<string, string>
     */
    protected static array $resolvedResources = [];

    /**
     * Resource bound from the panel route so generic CRUD pages
     * (ListEntries, CreateEntry, EditEntry) work without a subclass.
     */
    #[Locked]
    public ?string $boundResource = null;

    public static function hasResource(): bool
    {
        if (isset(static::$resource)) {
            return true;
        }

        if (isset(static::$resolvedResources[static::class])) {
            return true;
        }

        return static::resourceFromRoute() !== null;
    }

    public static function getResource(): string
    {
        if (isset(static::$resource)) {
            return static::$resource;
        }

        $bound = static::resourceFromRoute() ?? static::$resolvedResources[static::class] ?? null;

        if (is_string($bound)) {
            static::$resolvedResources[static::class] = $bound;

            return $bound;
        }

        throw new LogicException('Page ['.static::class.'] is not bound to a resource.');
    }

    public function bootHasResource(): void
    {
        $fromRoute = static::resourceFromRoute();

        if (is_string($fromRoute)) {
            static::$resolvedResources[static::class] = $fromRoute;
            $this->boundResource = $fromRoute;

            return;
        }

        if (is_string($this->boundResource) && is_a($this->boundResource, Resource::class, true)) {
            static::$resolvedResources[static::class] = $this->boundResource;

            return;
        }

        $this->boundResource = null;
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

    protected static function resourceFromRoute(): ?string
    {
        $resource = request()->route()?->defaults['uiResource'] ?? null;

        if (! is_string($resource) || ! is_a($resource, Resource::class, true)) {
            return null;
        }

        return $resource;
    }
}
