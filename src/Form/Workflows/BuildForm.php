<?php

namespace Streams\Ui\Form\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\SetStream;
use Streams\Ui\Support\Workflows\LoadAssets;
use Streams\Ui\Support\Workflows\SetOptions;
use Streams\Ui\Form\Workflows\Build\SetEntry;
use Streams\Ui\Form\Workflows\Build\LoadValues;
use Streams\Ui\Form\Workflows\Build\QueryEntry;
use Streams\Ui\Support\Workflows\MakeComponent;
use Streams\Ui\Form\Workflows\Build\BuildFields;
use Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Streams\Ui\Form\Workflows\Build\BuildActions;
use Streams\Ui\Form\Workflows\Build\BuildButtons;
use Streams\Ui\Form\Workflows\Build\ValidateForm;
use Streams\Ui\Form\Workflows\Build\AuthorizeForm;
use Streams\Ui\Form\Workflows\Build\BuildSections;
use Streams\Ui\Form\Workflows\Build\FlashMessages;
use Streams\Ui\Form\Workflows\Build\HandleRequest;
use Streams\Ui\Form\Workflows\Build\SetValidation;

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
