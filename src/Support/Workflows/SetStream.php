<?php

namespace Streams\Ui\Support\Workflows;

use Streams\Ui\Support\Builder;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

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
