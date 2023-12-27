<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Ui\Builders\Inputs\Concerns\HasPlaceholder;

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
        $this->query(function ($query, $state) {

            if ($this->isAbsolute()) {
                return $query->where($this->getName(), $state['value']);
            }

            return $query
                ->where($this->getName(), 'LIKE', '%' . $state['value'] . '%');
        });
    }
}
