<?php

namespace Streams\Ui\Table\Component\View\Query;

use Illuminate\Database\Eloquent\Builder;
use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Table\Component\View\Contract\ViewQueryInterface;

/**
 * Class TrashQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TrashQuery implements ViewQueryInterface
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
