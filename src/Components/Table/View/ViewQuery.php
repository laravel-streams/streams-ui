<?php

namespace Streams\Ui\Components\Table\View;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;
use Streams\Ui\Components\Table;
use Streams\Ui\Components\Table\View\View;
use Streams\Ui\Components\Table\TableBuilder;

class ViewQuery
{
    public function handle(Table $table, Builder $query, View $view)
    {
        if (!$query = $view->query) {
            return;
        }

        $view->fire('querying', compact('builder', 'query'));

        App::call($query, compact('builder', 'query'), 'handle');
    }
}
