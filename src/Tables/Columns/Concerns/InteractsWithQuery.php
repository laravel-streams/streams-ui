<?php

namespace Streams\Ui\Tables\Columns\Concerns;

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

    public function applySort(Criteria $query, string $direction = 'asc'): Criteria
    {
        if ($this->sortQuery) {

            $this->evaluate($this->sortQuery, [
                'direction' => $direction,
                'query' => $query,
            ]);

            return $query;
        }

        foreach (array_reverse($this->getSortColumns()) as $sortColumn) {
            // $query->orderBy($this->getSortColumnForQuery($query, $sortColumn), $direction);
            $query->orderBy($sortColumn, $direction);
        }

        return $query;
    }

    // protected function getSortColumnForQuery(
    //     Criteria $query,
    //     string $sortColumn,
    //     ?array $relationships = null
    // ): string | Criteria {
        
    //     $relationships ??= ($relationshipName = $this->getRelationshipName()) ?
    //         explode('.', $relationshipName) :
    //         [];

    //     if (!count($relationships)) {
    //         return $sortColumn;
    //     }

    //     $currentRelationshipName = array_shift($relationships);

    //     $relationship = $this->getRelationship($query->getModel(), $currentRelationshipName);

    //     $relatedQuery = $relationship->getRelated()::query();

    //     return $relationship
    //         ->getRelationExistenceQuery(
    //             $relatedQuery,
    //             $query,
    //             [$currentRelationshipName => $this->getSortColumnForQuery(
    //                 $relatedQuery,
    //                 $sortColumn,
    //                 $relationships,
    //             )],
    //         )
    //         ->applyScopes()
    //         ->getQuery();
    // }
}
