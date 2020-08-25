<?php

namespace Anomaly\Streams\Ui\Form\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Form\Workflows\Validate\SetMessages;
use Anomaly\Streams\Ui\Form\Workflows\Validate\BuildValidator;

/**
 * Class ValidateForm
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ValidateForm extends Workflow
{
    protected $steps = [
        BuildValidator::class,
        SetMessages::class,
    ];
}
