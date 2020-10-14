<?php

namespace Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Facades\Request;
use Streams\Ui\Form\FormBuilder;

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
     * @param \Streams\Ui\Form\FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if (!Request::isMethod('post')) {
            return;
        }

        $builder->validate();
    }
}
