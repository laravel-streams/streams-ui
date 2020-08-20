<?php

namespace Anomaly\Streams\Ui\Form\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Ui\Form\Workflows\Build\SetEntry;
use Anomaly\Streams\Ui\Support\Workflows\MakeInstance;
use Anomaly\Streams\Ui\Support\Workflows\SetRepository;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildFields;
use Anomaly\Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildActions;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildButtons;
use Anomaly\Streams\Ui\Form\Workflows\Build\HandleRequest;
use Anomaly\Streams\Ui\Form\Workflows\Build\AuthorizeForm;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildSections;

/**
 * Class BuildWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [

        /**
         * Make dat instance.
         */
        MakeInstance::class,

        /**
         * Integrate with others.
         */
        LoadAssets::class,
        LoadBreadcrumb::class,

        /**
         * Set important things.
         */
        SetStream::class,
        SetOptions::class,
        SetRepository::class,

        /**
         * Load the entry.
         */
        SetEntry::class,

        /**
         * Authorize the form.
         */
        AuthorizeForm::class,

        /**
         * Build-er up.
         */
        BuildFields::class,
        BuildActions::class,
        BuildButtons::class,
        BuildSections::class,

        /**
         * Handle POST Requests
         */
        HandleRequest::class,
    ];
}
