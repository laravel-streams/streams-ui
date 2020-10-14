<?php

namespace Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Form\FormBuilder;

/**
 * Class HandleRequest
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class HandleRequest
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

        //$builder->process();

        // if (!$builder->handler) {
        //     return;
        // }

        App::call($builder->handler, compact('builder'));

        $builder->response = redirect(request()->fullUrl());
    }
}
