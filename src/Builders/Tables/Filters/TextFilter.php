<?php

namespace Streams\Ui\Builders\Tables\Filters;

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
        $this->query(function ($query, $search) {

            if ($this->isAbsolute()) {
                return $query->where($this->getName(), $search);
            }

            return $query
                ->where($this->getName(), 'LIKE', '%' . $search . '%');
        });
    }
}
