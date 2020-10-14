<?php

namespace Streams\Ui\Form\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Form\Workflows\Process\CallHandler;

/**
 * Class ProcessForm
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ProcessForm extends Workflow
{
    protected $steps = [
        CallHandler::class,
    ];
}
