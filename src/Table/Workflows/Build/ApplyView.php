<?php

namespace Streams\Ui\Table\Workflows\Build;

use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class ApplyView
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ApplyView
{
    public function handle(TableBuilder $builder)
    {
        if (!$view = $builder->instance->views->active()) {
            return;
        }

        if ($view->options) {
            $builder->instance->options = $builder->instance->options->merge($view->options);
        }
    }
}
