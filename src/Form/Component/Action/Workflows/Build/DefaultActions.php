<?php

namespace Streams\Ui\Form\Component\Action\Workflows\Build;

use Streams\Ui\Form\FormBuilder;

/**
 * Class DefaultActions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultActions
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->actions) {
            return;
        }
    
        if ($builder->entry) {
            
            $builder->actions = [
                'update',
            ];

            return;
        }

        $builder->actions = [
            'save',
        ];
    }
}
