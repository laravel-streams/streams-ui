<?php

namespace Streams\Ui\Traits;

trait HasNavigationGroups
{
    protected bool $navigationMounted = false;

    protected array | \Closure $navigationGroups = [];

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

    public function navigationGroups(array | \Closure $groups): static
    {
        $this->navigationGroups = [
            ...$this->evaluate($this->navigationGroups),
            ...$groups,
        ];

        return $this;
    }

    public function getNavigationGroups(): array
    {
        return $this->navigationGroups;
    }
}
