<?php namespace Streams\Ui\Components\Table\View\Query;

use Streams\Ui\Components\Table\TableBuilder;
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
