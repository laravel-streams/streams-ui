<?php

namespace Streams\Ui\Builders\Tables\Columns\Concerns;

use Streams\Core\Criteria\Criteria;

trait InteractsWithQuery
{
    public function applySearch(
        Criteria $query,
        string $search,
        bool $isFirst
    ): Criteria {
        
        // if ($this->searchQuery) {
        //     $whereClause = $isFirst ? 'where' : 'orWhere';

        //     $query->{$whereClause}(
        //         fn ($query) => $this->evaluate($this->searchQuery, [
        //             'query' => $query,
        //             'search' => $search,
        //             'searchQuery' => $search,
        //         ]),
        //     );

        //     $isFirst = false;

        //     return $query;
        // }

        // /** @var Connection $databaseConnection */
        // $databaseConnection = $query->getConnection();

        // $model = $query->getModel();

        // $isSearchForcedCaseInsensitive = $this->isSearchForcedCaseInsensitive();

        // $search = generate_search_term_expression($search, $isSearchForcedCaseInsensitive, $databaseConnection);

        // $translatableContentDriver = $this->getLivewire()->makeFilamentTranslatableContentDriver();

        foreach ($this->getSearchColumns() as $column) {

            $where = $isFirst ? 'where' : 'orWhere';

            $query->{$where}($column, 'LIKE', '%' . $search . '%');

            $isFirst = false;
        }

        return $query;
    }
}
