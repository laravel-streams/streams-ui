<?php

namespace Streams\Ui\Table\Component\View\Workflows\Views;

use Streams\Ui\Table\TableBuilder;

/**
 * Class DefaultViews
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultViews
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        //if ($stream->trashable && !$builder->views && !$builder->async) {
        // $builder->views = [
        //     'all',
        //     'trash',
        // ];
        //}
    }
}
