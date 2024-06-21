<?php

namespace Streams\Ui\Tables\Filters;

use Streams\Ui\Inputs;
use Streams\Ui\Builders;
use Streams\Ui\Tables\Table;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Tables\Filters\Filter;

class SelectFilter extends Filter
{
    use Inputs\Traits\HasOptions;
    use Builders\Concerns\HasLabel;

    protected string $view = 'ui::builders.filters.select';

    protected function setUp(): void
    {
        $this->query(function (Criteria $query, Table $table, $state) {
            return $query->where($this->getName(), $state);
        });
    }
}
