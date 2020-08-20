<?php

namespace Anomaly\Streams\Ui\Form;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Form\Command\SaveForm;
use Anomaly\Streams\Ui\Form\Command\ValidateForm;
use Anomaly\Streams\Ui\Form\Command\LoadFormValues;
use Anomaly\Streams\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Ui\Form\Command\FlashFormErrors;
use Anomaly\Streams\Ui\Form\Workflows\QueryWorkflow;
use Anomaly\Streams\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Ui\Form\Command\FlashFieldValues;
use Anomaly\Streams\Ui\Form\Workflows\Build\SetEntry;
use Anomaly\Streams\Ui\Support\Workflows\MakeComponent;
use Anomaly\Streams\Ui\Support\Workflows\SetRepository;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildFields;
use Anomaly\Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Anomaly\Streams\Ui\Form\Component\Field\FieldBuilder;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildActions;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildButtons;
use Anomaly\Streams\Ui\Form\Workflows\Build\AuthorizeForm;
use Anomaly\Streams\Ui\Form\Workflows\Build\BuildSections;
use Anomaly\Streams\Ui\Form\Workflows\Build\HandleRequest;

/**
 * Class FormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormBuilder extends Builder
{

    protected $workflows = [
        'build' => [
            MakeComponent::class,
            LoadAssets::class,
            LoadBreadcrumb::class,
            SetStream::class,
            SetOptions::class,
            SetRepository::class,

            SetEntry::class,

            AuthorizeForm::class,

            BuildFields::class,
            BuildActions::class,
            BuildButtons::class,
            BuildSections::class,

            HandleRequest::class,
        ]
    ];

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'async' => false,
        'handler' => null,
        'validator' => null,

        'stream' => null,
        'repository' => null,

        'entry' => null,

        'fields' => [],
        'skips' => [],
        'rules' => [],
        'assets' => [],
        'actions' => [],
        'buttons' => [],
        'options' => [],
        'sections' => [],

        'save' => true,
        'read_only' => false,

        'component' => 'form',

        'form' => Form::class,

        'field_builder' => FieldBuilder::class,

        //'build_workflow' => BuildWorkflow::class,
        'query_workflow' => QueryWorkflow::class,
    ];

    //---------------------------------------------------------------------
    //-------------------------    Old Shit    ----------------------------
    //---------------------------------------------------------------------

    /**
     * Validate the form.
     *
     * @return $this
     */
    public function validate()
    {
        dispatch_now(new LoadFormValues($this));
        dispatch_now(new ValidateForm($this));

        return $this;
    }

    /**
     * Flash form information to be
     * used in conjunction with redirect
     * type responses (not self handling).
     */
    public function flash()
    {
        dispatch_now(new FlashFormErrors($this));
        dispatch_now(new FlashFieldValues($this));
    }

    /**
     * Save the form.
     */
    public function saveForm()
    {
        dispatch_now(new SaveForm($this));
    }
}
