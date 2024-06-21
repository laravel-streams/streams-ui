<?php

namespace Streams\Ui\Tables\Filters;

use Streams\Ui\Tables\Table;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Inputs\Traits\HasPlaceholder;

class TextFilter extends Filter
{
    use HasPlaceholder;

    protected bool | \Closure | null $absolute = null;

    public function absolute(bool | \Closure | null $absolute = true): static
    {
        $this->absolute = $absolute;

        return $this;
    }

    public function isAbsolute(): bool
    {
        return (bool) $this->evaluate($this->absolute);
    }

    protected function setUp(): void
    {
        $this->query(function (Criteria $query, Table $table, $state) {

            if ($this->isAbsolute()) {
                return $query->where($this->getName(), $state);
            }

            return $query
                ->where($this->getName(), 'LIKE', '%' . $state . '%');
        });
    }
}
