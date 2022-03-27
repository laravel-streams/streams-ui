<?php

namespace Streams\Ui\Components\Table\View;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;
use Streams\Ui\Components\Table\TableBuilder;
use Streams\Ui\Components\Table\View\View;

/**
 * Class ViewQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewQuery
{

    /**
     * Handle the view query.
     *
     * @param  TableBuilder $builder
     * @param  Builder $query
     * @param  View $view
     * @return mixed
     * @throws \Exception
     */
    public function handle(TableBuilder $builder, Builder $query, View $view)
    {
        if (!$query = $view->query) {
            return;
        }

        $view->fire('querying', compact('builder', 'query'));

        App::call($query, compact('builder', 'query'), 'handle');
    }
}
