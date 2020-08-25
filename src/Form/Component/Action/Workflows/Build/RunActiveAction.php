<?php

namespace Anomaly\Streams\Ui\Form\Component\Action\Workflows\Build;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class RunActiveAction
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RunActiveAction
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

        if (!$action = $builder->instance->actions->active()) {
            return;
        }

        if (!$action->handler) {
            return;
        }

        App::call($action->handler, compact('builder'), 'handle');
    }
}
