<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Validate;

use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Support\Facades\Messages;

/**
 * Class SetMessages
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetMessages
{
    public function handle(FormBuilder $builder)
    {
        $builder->instance->errors = $builder->validator->messages();
    }
}
