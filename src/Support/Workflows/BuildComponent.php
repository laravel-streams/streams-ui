<?php

namespace Streams\Ui\Support\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\SetStream;
use Streams\Ui\Support\Workflows\SetOptions;
use Streams\Ui\Support\Workflows\LoadAssets;
use Streams\Ui\Support\Workflows\MakeComponent;

/**
 * Class BuildComponent
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildComponent extends Workflow
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
