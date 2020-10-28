<?php

namespace Streams\Ui\Form\Component\Action;

use Streams\Ui\Form\FormBuilder;
use Illuminate\Support\Facades\App;
use Streams\Ui\Form\Component\Action\Action;

/**
 * Class ActionResponder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionResponder
{

    /**
     * Set the form response using the active action
     * form response handler.
     *
     * @param FormBuilder $builder
     * @param             $action
     */
    public function setFormResponse(FormBuilder $builder, Action $action)
    {
        $handler = $action->handler;

        /*
         * If the handler is a closure or callable
         * string then call it using the service container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            App::call($handler, compact('builder'), 'handle');
        }
    }
}
