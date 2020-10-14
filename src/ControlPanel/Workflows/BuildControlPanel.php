<?php

namespace Streams\Ui\ControlPanel\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\SetStream;
use Streams\Ui\Support\Workflows\LoadAssets;
use Streams\Ui\Support\Workflows\SetOptions;
use Streams\Ui\Support\Workflows\MakeComponent;
use Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Streams\Ui\ControlPanel\Workflows\Build\BuildNavigation;

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
