<?php

namespace Anomaly\Streams\Ui\Form\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Ui\Form\Workflows\Build\SetEntry;
use Anomaly\Streams\Ui\Form\Workflows\Build\LoadValues;
use Anomaly\Streams\Ui\Form\Workflows\Build\QueryEntry;
use Anomaly\Streams\Ui\Support\Workflows\MakeComponent;
use Anomaly\Streams\Ui\Support\Workflows\SetRepository;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildFields;
use Anomaly\Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildActions;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildButtons;
use Anomaly\Streams\Ui\Form\Workflows\Build\ValidateForm;
use Anomaly\Streams\Ui\Form\Workflows\Build\AuthorizeForm;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildSections;
use Anomaly\Streams\Ui\Form\Workflows\Build\FlashMessages;
use Anomaly\Streams\Ui\Form\Workflows\Build\HandleRequest;
use Anomaly\Streams\Ui\Form\Workflows\Build\SetValidation;

/**
 * Class BuildForm
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildForm extends Workflow
{
    protected $steps = [
        MakeComponent::class,
        
        SetStream::class,
        SetOptions::class,

        LoadAssets::class,
        LoadBreadcrumb::class,        
        
        SetRepository::class,
        QueryEntry::class,
        SetEntry::class,
        
        AuthorizeForm::class,

        SetValidation::class,
        
        BuildFields::class,
        BuildActions::class,
        BuildButtons::class,
        BuildSections::class,
        
        LoadValues::class,
        
        ValidateForm::class,
        FlashMessages::class,
        
        HandleRequest::class,
    ];
}
