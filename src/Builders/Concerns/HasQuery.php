<?php

namespace Streams\Ui\Builders\Concerns;

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
        return $this->evaluate($this->query);
    }
}
