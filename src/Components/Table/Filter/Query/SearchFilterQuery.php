<?php

namespace Streams\Ui\Components\Table\Filter\Query;

use Illuminate\Support\Arr;
use Streams\Ui\Components\Table;
use Illuminate\Support\Facades\App;
use Streams\Ui\Components\Table\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SearchFilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SearchFilterQuery
{

    /**
     * Handle the filter.
     *
     * @param TableBuilder $builder
     * @param CriteriaInterface $criteria
     */
    public function handle(Table $table, Filter $filter)
    {
        $search = $filter->fields ?: ([$filter->column ?: $filter->handle]);

        dd($search);
        $table->criteria->where($filter->column ?: $filter->handle, 'LIKE', '%' . $filter->value() . '%');
    }

    /**
     * Handle the filter.
     *
     * @param Builder $query
     * @param Filter $filter
     */
    // public function handle(Builder $query, Table $table, Filter $filter)
    // {
    //     $stream = $filter->stream;

    //     $query->where(
    //         function (Builder $query) use ($filter, $stream, $table) {

    //             /* @var Builder|HasAttributes $query */
    //             $casts = $query
    //                 ->getModel()
    //                 ->getCasts();

    //             foreach ($filter->columns as $column) {

    //                 $value = $filter->getValue();

    //                 if (Arr::get($casts, $column) == 'json') {
    //                     $value = addslashes(substr(json_encode($value), 1, -1));
    //                 }

    //                 $query->orWhere($column, 'LIKE', "%{$value}%");
    //             }

    //             foreach ($filter->fields as $field) {

    //                 $filter->field = $field;

    //                 $fieldType      = $stream->fields->get($field)->type();
    //                 $fieldTypeQuery = $fieldType->query;

    //                 $fieldTypeQuery->setConstraint('or');

    //                 App::call($fieldTypeQuery, compact('query', 'filter', 'builder', 'stream'), 'filter');
    //             }
    //         }
    //     );
    // }
}
