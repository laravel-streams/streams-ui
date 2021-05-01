<?php

namespace Streams\Ui\Table\View\Query;

use Streams\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

class TrashQuery
{

    /**
     * Handle the query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function handle(TableBuilder $builder, Builder $query)
    {
        $query->onlyTrashed();
    }
}
