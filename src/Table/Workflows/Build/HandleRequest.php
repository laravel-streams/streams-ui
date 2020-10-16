<?php

namespace Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\TableBuilder;

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

        if (!$active = $builder->instance->actions->active()) {
            return;
        }

        $selected = (array) $builder->request('id');

        App::call($active->handler, compact('builder', 'selected'), 'handle');
    }
}
