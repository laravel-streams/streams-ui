<?php

namespace Anomaly\Streams\Ui\Support\Workflows;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Facades\Streams;

/**
 * Class SetStream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetStream
{

    /**
     * Handle the step.
     * 
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        if ($builder->stream instanceof Stream) {

            $builder->instance->stream = $builder->stream;

            return;
        }

        $builder->instance->stream = $builder->stream = Streams::make($builder->stream);
    }
}
