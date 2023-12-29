<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Inputs\Concerns\HasPlaceholder;

class SearchFilter extends Filter
{
    use HasPlaceholder;

    protected string $view = 'ui::builders.filters.search';

    protected function setUp(): void
    {
        $this->query(function (Criteria $query, Table $table, $state): Criteria {

            $search = '%' . $state['value'] . '%';

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
