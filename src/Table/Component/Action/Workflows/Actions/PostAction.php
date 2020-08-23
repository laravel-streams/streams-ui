<?php

namespace Anomaly\Streams\Ui\Table\Component\Action\Workflows\Actions;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class PostAction
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostAction
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!Request::is('POST')) {
            return;
        }

        if (!$active = $builder->instance->actions->active()) {
            return;
        }

        $handler = $active->handler ?: [$active, 'post'];

        App::call($handler, compact('builder'), 'handle');
    }
}
