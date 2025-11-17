<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Ui\Inputs;
use Streams\Ui\Builders;
use Streams\Ui\Builders\Tables\Table;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\Tables\Filters\Filter;

class SelectFilter extends Filter
{
    use Inputs\Traits\HasOptions;
    use Inputs\Traits\HasPlaceholder;
    
    use Builders\Concerns\HasLabel;

    protected string $view = 'ui::builders.filters.select';

    protected function setUp(): void
    {
        $this->query(function (Criteria $query, Table $table, $state) {
            return $query->where($this->getName(), $state);
        });
    }

    protected bool $required = false;

    public function required(bool | \Closure $required = true)
    {
        $this->required = $required;

        return $this;
    }

    public function isRequired(): bool
    {
        return (bool) $this->evaluate($this->required);
    }
}
