<?php

namespace Streams\Ui\Components\Table\View\Query;

use Streams\Ui\Components\Table\TableBuilder;
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
