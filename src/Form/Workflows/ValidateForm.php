<?php

namespace Streams\Ui\Form\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Form\Workflows\Validate\SetMessages;
use Streams\Ui\Form\Workflows\Validate\BuildValidator;

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
