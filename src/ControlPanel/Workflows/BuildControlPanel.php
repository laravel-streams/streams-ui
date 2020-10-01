<?php

namespace Anomaly\Streams\Ui\ControlPanel\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Ui\Support\Workflows\MakeComponent;
use Anomaly\Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Anomaly\Streams\Ui\ControlPanel\Workflows\Build\BuildNavigation;

/**
 * Class BuildControlPanel
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildControlPanel extends Workflow
{
    protected $steps = [
        MakeComponent::class,

        SetStream::class,
        SetOptions::class,
        
        LoadAssets::class,
        LoadBreadcrumb::class,        

        BuildNavigation::class,
    ];
}
