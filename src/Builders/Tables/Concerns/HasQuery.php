<?php

namespace Streams\Ui\Builders\Tables\Concerns;

use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Database\Query\Builder;

trait HasQuery
{
    protected Criteria|Builder|\Closure|null $query = null;

    public function query(Criteria|Builder|\Closure|null $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getQuery(): Criteria|Builder
    {
        if ($query = $this->evaluate($this->query)) {
            return $query;
        }

        // if ($query = $this->getRelationshipQuery()) {
        //     return $this->applyQueryScopes($query->clone());
        // }

        $livewire = $this->getLivewire()::class;

        throw new \Exception("Component [{$livewire}] must have a [query()].");
    }
}
