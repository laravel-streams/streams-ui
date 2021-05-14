<?php

namespace Streams\Ui\Table\Filter\Query;

use Streams\Ui\Table\Table;
use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Table\Filter\Filter;
use Streams\Core\Criteria\Contract\CriteriaInterface;

class GenericFilterQuery
{

    /**
     * Handle the filter.
     *
     * @param TableBuilder $builder
     * @param CriteriaInterface $criteria
     */
    public function handle(Table $table, Filter $filter)
    {
        if (!$filter->fields) {

            $table->criteria->where($filter->column ?: $filter->handle, 'LIKE', '%' . $filter->value() . '%');

            return;
        }

        foreach ($filter->fields as $field) {
            $table->criteria->orWhere($field, 'LIKE', '%' . $filter->value() . '%');
        }
    }
}
