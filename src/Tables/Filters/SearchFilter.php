<?php

namespace Streams\Ui\Tables\Filters;

use Streams\Core\Criteria\Criteria;
use Streams\Ui\Tables\Table;
use Streams\Ui\Inputs\Traits\HasPlaceholder;

class SearchFilter extends Filter
{
    use HasPlaceholder;

    protected string $view = 'ui::builders.filters.search';

    protected function setUp(): void
    {
        $this->query(function (Criteria $query, Table $table, $state): Criteria {

            $search = '%' . $state . '%';

            foreach ($table->getColumns() as $column) {

                if (!$column->isSearchable()) {
                    continue;
                }
                
                foreach ($column->getSearchColumns() as $searchColumn) {
                    $query->orWhere($searchColumn, 'LIKE', $search);
                }
            }

            return $query;
        });
    }
}
