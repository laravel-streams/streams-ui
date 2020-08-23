<?php

namespace Anomaly\Streams\Ui\Form\Component\Section\Workflows\Sections;

use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class DefaultSections
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultSections
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->fields) {
            return;
        }
    
        /**
         * If no fields are set and this
         * is a streams field - we can just
         * move the fields over and be done.
         */
        if ($builder->stream) {
            
            $builder->instance->fields = $builder->stream->fields;
            
            return;
        }
    }
}
