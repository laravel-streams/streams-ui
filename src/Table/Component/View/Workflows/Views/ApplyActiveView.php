<?php

namespace Anomaly\Streams\Ui\Table\Component\View\Workflows\Views;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Table\Component\View\ViewHandler;

/**
 * Class ApplyActiveView
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ApplyActiveView
{

    /**
     * Handle the command.
     *
     * @param Request $request
     * @param Container $container
     */
    public function handle(TableBuilder $builder, Request $request, ViewHandler $handler)
    {
        if (!$active = $builder->instance->views->active()) {
            return;
        }

        // Nothing to do.
        if (!$active) {
            return;
        }

        if ($active->filters) {
            $builder->filters = $active->filters;
        }

        if ($active->columns) {
            $builder->columns = $active->columns;
        }

        if ($active->buttons) {
            $builder->buttons = $active->buttons;
        }

        if ($active->actions) {
            $builder->actions = $active->actions;
        }

        if ($active->options) {
            $builder->options = $active->options;
        }

        if ($active->entries) {
            $builder->entries = $active->entries;
        }

        $handler->handle($builder, $active);
    }
}
