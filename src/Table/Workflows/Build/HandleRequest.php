<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class HandleRequest
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class HandleRequest
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!Request::isMethod('post')) {
            return;
        }

        foreach ($builder->instance->actions->active() as $action) {
            App::call($action->handler, compact('builder'));
        }
    }
}
