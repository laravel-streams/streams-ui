<?php

namespace Streams\Ui\Support\Workflows;

use Illuminate\Support\Facades\App;
use Streams\Ui\Support\Builder;
use Streams\Core\Stream\Contract\StreamInterface;
use Streams\Core\Repository\Contract\RepositoryInterface;
use Streams\Core\Stream\Stream;

/**
 * Create a new SetRepository instance.
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetRepository
{

    /**
     * Handle the command.
     *
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        if ($builder->repository instanceof RepositoryInterface) {
            return;
        }

        /**
         * Default to configured.
         */
        if ($builder->repository) {
            $builder->repository = App::make($builder->repository, compact('builder'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->repository && $builder->stream instanceof Stream) {
            $builder->repository = $builder->stream->repository();
        }
    }
}
