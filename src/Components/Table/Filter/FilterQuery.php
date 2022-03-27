<?php

namespace Streams\Ui\Components\Table\Filter;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;
use Streams\Ui\Components\Table\TableBuilder;
use Streams\Ui\Components\Table\Filter\Filter;
use Streams\Core\Criteria\Contract\CriteriaInterface;

/**
 * Class FilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FilterQuery
{

    /**
     * Modify the table's query using the filters.
     *
     * @param TableBuilder $builder
     * @param Filter $filter
     * @param CriteriaInterface $criteria
     */
    public function filter(TableBuilder $builder, Filter $filter, CriteriaInterface $criteria)
    {

        /*
         * If the filter is self handling then let
         * it filter the query itself.
         */
        if (method_exists($filter, 'handle')) {
            App::call([$filter, 'handle'], compact('builder', 'criteria', 'filter'));

            return;
        }

        $handler = $filter->query;

        // Self handling implies @handle
        if (is_string($handler) && !Str::contains($handler, '@')) {
            $handler .= '@handle';
        }

        /*
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            App::call($handler, compact('builder', 'criteria', 'filter'));
        }
    }
}
