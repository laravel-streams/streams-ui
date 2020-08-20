<?php namespace Anomaly\Streams\Ui\Table\Component\View\Query;

use Anomaly\Streams\Ui\Table\Component\View\Contract\ViewQueryInterface;
use Anomaly\Streams\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ViewAllQueryQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RecentlyCreatedQuery implements ViewQueryInterface
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
