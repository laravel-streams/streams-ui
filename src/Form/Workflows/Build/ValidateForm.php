<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class ValidateForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ValidateForm
{

    /**
     * Handle the step
     *
     * @param \Anomaly\Streams\Ui\Form\FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if (!Request::isMethod('post')) {
            return;
        }

        $builder->validate();
    }
}
