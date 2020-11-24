<?php

namespace Streams\Ui\Table\Component\Filter\Query;

use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Table\Component\Filter\Filter;
use Streams\Core\Criteria\Contract\CriteriaInterface;

/**
 * Class GenericFilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GenericFilterQuery
{

    /**
     * Handle the filter.
     *
     * @param TableBuilder $builder
     * @param CriteriaInterface $criteria
     */
    public function handle(TableBuilder $builder, Filter $filter)
    {
        $builder->criteria->where($filter->column ?: $filter->handle, 'LIKE', '%' . $filter->value() . '%');
    }
}
