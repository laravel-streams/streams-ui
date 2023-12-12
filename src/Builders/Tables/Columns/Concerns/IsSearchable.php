<?php

namespace Streams\Ui\Builders\Tables\Columns\Concerns;

use Illuminate\Support\Arr;

trait IsSearchable
{
    //protected bool $isGloballySearchable = false;

    //protected bool $isIndividuallySearchable = false;

    protected bool $searchable = false;

    protected ?array $searchColumns = null;

    protected ?\Closure $searchQuery = null;

    protected bool | \Closure | null $isSearchForcedCaseInsensitive = null;

    public function searchable(
        bool | array | string $condition = true,
        ?\Closure $query = null,
        // bool $isIndividual = false,
        // bool $isGlobal = true,
    ): static {
        
        if (is_bool($condition)) {
            $this->searchable = $condition;
            $this->searchColumns = null;
        } else {
            $this->searchable = true;
            $this->searchColumns = Arr::wrap($condition);
        }

        // $this->isGloballySearchable = $isGlobal;
        // $this->isIndividuallySearchable = $isIndividual;
        $this->searchQuery = $query;

        return $this;
    }

    public function getSearchColumns(): array
    {
        return $this->searchColumns ?? $this->getDefaultSearchColumns();
    }

    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    // public function isGloballySearchable(): bool
    // {
    //     return $this->isSearchable() && $this->isGloballySearchable;
    // }

    // public function isIndividuallySearchable(): bool
    // {
    //     return $this->isSearchable() && $this->isIndividuallySearchable;
    // }

    public function getDefaultSearchColumns(): array
    {
        return [(string) str($this->getName())->afterLast('.')];
    }
}
