<?php namespace Streams\Ui\Table\Component\View\Query;

use Streams\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

class RecentlyModifiedQuery
{

    /**
     * Handle the query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function handle(TableBuilder $builder, Builder $query)
    {
        $query
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc');
    }
}
