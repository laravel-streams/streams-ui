<?php

namespace Streams\Ui\Form\Workflows\Build;

use Streams\Ui\Form\FormBuilder;
use Streams\Core\Repository\Contract\RepositoryInterface;

/**
 * Class SetEntry
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetEntry
{

    /**
     * Handle the command.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {

        /*
         * If the entry is already
         * set then skip this step.
         */
        if ($builder->entry) {
            return;
        }

        /*
         * Fallback to using the repository 
         * to get and/or paginate the results.
         */
        if ($builder->repository() instanceof RepositoryInterface) {

            $builder->entry = $builder->instance->entry = $builder->repository()->newInstance();

            return;
        }
    }
}
