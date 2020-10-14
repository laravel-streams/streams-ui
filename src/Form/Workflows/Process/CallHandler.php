<?php

namespace Streams\Ui\Form\Workflows\Process;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Form\FormBuilder;

/**
 * Class CallHandler
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class CallHandler
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
        
        if (!$builder->handler) {
            return;
        }

        App::call($builder->handler, compact('builder'), 'handle');
    }
}
