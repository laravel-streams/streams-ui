<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Ui\Builders;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\Tables\Table;

class SelectFilter extends Filter
{
    use Builders\Concerns\HasLabel;
    use Builders\Inputs\Traits\HasOptions;
    use Builders\Inputs\Traits\HasPlaceholder;

    protected string $view = 'ui::builders.filters.select';

    protected function setUp(): void
    {
        $this->query(function (Criteria $query, Table $table, $state) {
            return $query->where($this->getName(), $state);
        });
    }

    protected bool $required = false;

    public function required(bool|\Closure $required = true)
    {
        $this->required = $required;

        return $this;
    }

    public function isRequired(): bool
    {
        return (bool) $this->evaluate($this->required);
    }
}
