<?php

namespace Anomaly\Streams\Ui\Support\Workflows;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class MakeComponent
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MakeComponent
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        $parameters = $builder->getAttributes();
        
        $abstract = Arr::pull($parameters, $builder->component);
        
        $builder->{$builder->component} = App::make($abstract, $parameters);
    }
}
