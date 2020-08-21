<?php

namespace Anomaly\Streams\Ui\Support\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Ui\Support\Workflows\MakeComponent;

/**
 * Class BuildWorkflow
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [

        MakeComponent::class,

        LoadAssets::class,

        SetStream::class,
        SetOptions::class,
    ];
}
