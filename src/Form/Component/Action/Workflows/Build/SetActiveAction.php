<?php

namespace Anomaly\Streams\Ui\Form\Component\Action\Workflows\Build;

use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class SetActiveAction
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveAction
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if (!Request::isMethod('post')) {
            return;
        }
        
        if ($builder->instance->actions->active()) {
            return;
        }

        if ($action = $builder->instance->actions->get($builder->request('action'))) {
            $action->active = true;
        }
    }
}
