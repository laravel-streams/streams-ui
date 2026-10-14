<?php

namespace Streams\Ui\Builders\Tables\Filters;

class CriteriaFilter extends Filter
{
    protected string $view = 'ui::builders.filters.filter';

    public function criteria(\Closure $criteria): static
    {
        return $this->query($criteria);
    }
}
