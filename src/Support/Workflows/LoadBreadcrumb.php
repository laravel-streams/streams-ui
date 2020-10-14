<?php

namespace Streams\Ui\Support\Workflows;

use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Breadcrumb;

/**
 * Class LoadBreadcrumb
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadBreadcrumb
{

    /**
     * Handle the command.
     *
     * @param Builder $builder
     * @param Breadcrumb $breadcrumbs
     */
    public function handle(Builder $builder, Breadcrumb $breadcrumbs)
    {
        if ($breadcrumb = $builder->instance->options->get('breadcrumb')) {
            $breadcrumbs->put($breadcrumb, '#');
        }
    }
}
