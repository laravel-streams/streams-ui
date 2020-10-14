<?php

namespace Streams\Ui\Table\Component\View\Workflows\Views;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Table\Component\View\ViewHandler;

/**
 * Class SetActiveView
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveView
{

    /**
     * Handle the command.
     *
     * @param Request $request
     * @param Container $container
     */
    public function handle(TableBuilder $builder, Request $request, ViewHandler $handler)
    {
        if ($builder->instance->views->active()) {
            return;
        }

        if ($view = $builder->instance->views->findByHandle($request->get($builder->instance->options->get('prefix') . 'view'))) {
            $view->active = true;
        }

        if (!$view && $view = $builder->instance->views->first()) {
            $view->active = true;
        }
    }
}
