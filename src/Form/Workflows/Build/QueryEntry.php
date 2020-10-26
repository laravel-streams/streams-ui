<?php

namespace Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Arr;
use Streams\Ui\Form\FormBuilder;
use Streams\Core\Support\Facades\Resolver;
use Streams\Core\Support\Facades\Evaluator;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Repository\Contract\RepositoryInterface;

/**
 * Class QueryEntry
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class QueryEntry
{

    /**
     * Handle the command.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {

        /*
         * If the builder has an entry handler
         * then call it through the container and
         * let it load the entry itself.
         */
        if (
            (is_string($builder->entry) && class_exists($builder->entry))
            || $builder->entry instanceof \Closure
        ) {

            $entry = Resolver::resolve($builder->entry, compact('builder'));

            $builder->entry = Evaluator::evaluate($entry ?: $builder->entry, compact('builder'));

            return;
        }

        /**
         * If the builder already has
         * an entry then just use that.
         */
        if ($builder->entry && is_object($builder->entry)) {

            $builder->instance->entry = $builder->entry;

            return;
        }

        /*
         * Fallback to using the repository 
         * to get and/or paginate the results.
         */
        if ($builder->repository instanceof RepositoryInterface) {

            $workflow = Arr::get($builder->workflows, 'query');

            (new $workflow)->setPrototypeAttribute('name', 'query_form')->passThrough($builder)->process([
                'builder' => $builder,
            ]);

            return;
        }
    }
}
