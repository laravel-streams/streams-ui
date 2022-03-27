<?php namespace Streams\Ui\Components\Table\View\Query;

use Streams\Ui\Components\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ViewAllQueryQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RecentlyCreatedQuery
{

    /**
     * Handle the query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function handle(TableBuilder $builder, Builder $query)
    {
        $query->orderBy('created_at', 'desc');
    }
}
