<?php

namespace Streams\Ui\Panels\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Streams\Ui\Navigation\NavigationItem;
use Streams\Ui\Navigation\NavigationGroup;

trait HasNavigation
{
    protected bool $navigationMounted = false;

    protected array $navigationGroups = [];

    protected array $navigationItems = [];

    // protected \Closure | bool $navigationBuilder = true;

    // public function navigation(\Closure | bool $builder = true): static
    // {
    //     $this->navigationBuilder = $builder;

    //     return $this;
    // }

    // public function buildNavigation(): array
    // {
    //     $builder = app()->call($this->navigationBuilder);

    //     return $builder->getNavigation();
    // }

    // public function hasNavigation(): bool
    // {
    //     return $this->navigationBuilder !== false;
    // }

    public function mountNavigation(): void
    {
        foreach ($this->getPages() as $page) {
            $page::registerNavigationItems($this);
        }

        foreach ($this->getResources() as $resource) {
            $resource::registerNavigationItems($this);
        }

        $this->navigationMounted = true;
    }

    public function navigationGroups(array $groups): static
    {
        $this->navigationGroups = [
            ...$this->navigationGroups,
            ...$groups,
        ];

        return $this;
    }

    public function getNavigationGroups(): array
    {
        return $this->navigationGroups;
    }

    public function navigationItems(array $items): static
    {
        $this->navigationItems = [
            ...$this->navigationItems,
            ...$items,
        ];

        return $this;
    }

    public function getNavigationItems(): array
    {
        return $this->navigationItems;
    }

    public function getNavigation(): array
    {
        // if ($this->navigationBuilder instanceof \Closure) {
        //     return $this->buildNavigation();
        // }

        if (!$this->navigationMounted) {
            $this->mountNavigation();
        }

        return $this->once(__METHOD__, function () {
            return collect($this->getNavigationItems())
                ->filter(fn (NavigationItem $item): bool => $item->isVisible())
                ->sortBy(fn (NavigationItem $item): int => $item->getSort())
                ->groupBy(fn (NavigationItem $item): ?string => $item->getGroup())
                ->map(function (Collection $items, ?string $groupIndex): NavigationGroup {

                    if (blank($groupIndex)) {
                        return NavigationGroup::make()->items($items);
                    }

                    $registeredGroup = collect($this->getNavigationGroups())
                        ->first(function (
                            NavigationGroup | string $registeredGroup,
                            string | int $registeredGroupIndex
                        ) use ($groupIndex) {

                            if ($registeredGroupIndex === $groupIndex) {
                                return true;
                            }

                            if ($registeredGroup === $groupIndex) {
                                return true;
                            }

                            if (!$registeredGroup instanceof NavigationGroup) {
                                return false;
                            }

                            return $registeredGroup->getLabel() === $groupIndex;
                        });

                    if ($registeredGroup instanceof NavigationGroup) {
                        return $registeredGroup->items($items);
                    }

                    return NavigationGroup::make($registeredGroup ?? $groupIndex)
                        ->items($items);
                })
                ->sortBy(function (NavigationGroup $group, ?string $groupIndex): int {

                    if (blank($group->getLabel())) {
                        return -1;
                    }

                    $registeredGroups = $this->getNavigationGroups();

                    $groupsToSearch = $registeredGroups;

                    if (Arr::first($registeredGroups) instanceof NavigationGroup) {
                        $groupsToSearch = [
                            ...array_keys($registeredGroups),
                            ...array_map(fn (NavigationGroup $registeredGroup): string => $registeredGroup->getLabel(), array_values($registeredGroups)),
                        ];
                    }

                    $sort = array_search(
                        $groupIndex,
                        $groupsToSearch,
                    );

                    if ($sort === false) {
                        return count($registeredGroups);
                    }

                    return $sort;
                })
                ->all();
        });
    }
}
