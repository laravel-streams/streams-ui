<?php

namespace Anomaly\Streams\Ui\Support\Workflows;

use Anomaly\Streams\Platform\Support\Breadcrumb;
use Anomaly\Streams\Ui\Support\Builder;

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
