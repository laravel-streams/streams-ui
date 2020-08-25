<?php

namespace Anomaly\Streams\Ui\Form\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Form\Workflows\Process\CallHandler;

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
