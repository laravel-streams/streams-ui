<?php

namespace Anomaly\Streams\Ui\Form;

use Anomaly\Streams\Ui\Form\Form;
use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Form\Command\SaveForm;
use Anomaly\Streams\Ui\Form\Workflows\BuildForm;
use Anomaly\Streams\Ui\Form\Workflows\QueryForm;
use Anomaly\Streams\Ui\Form\Command\ValidateForm;
use Anomaly\Streams\Ui\Form\Command\LoadFormValues;
use Anomaly\Streams\Ui\Form\Command\FlashFormErrors;
use Anomaly\Streams\Ui\Form\Command\FlashFieldValues;
use Anomaly\Streams\Ui\Form\Component\Field\FieldBuilder;
use Anomaly\Streams\Ui\Form\Component\Action\ActionBuilder;
use Anomaly\Streams\Ui\Form\Component\Button\ButtonBuilder;
use Anomaly\Streams\Ui\Form\Component\Section\SectionBuilder;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\BuildFields;
use Anomaly\Streams\Ui\Form\Component\Action\Workflows\BuildActions;
use Anomaly\Streams\Ui\Form\Component\Button\Workflows\BuildButtons;
use Anomaly\Streams\Ui\Form\Component\Section\Workflows\BuildSections;

/**
 * Class FormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormBuilder extends Builder
{

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

        'can_save' => true,

        'component' => 'form',
        'form' => Form::class,

        'options' => [
            'read_only' => false,
        ],

        'builders' => [
            'fields' => FieldBuilder::class,
            'actions' => ActionBuilder::class,
            'buttons' => ButtonBuilder::class,
            'sections' => SectionBuilder::class,
        ],

        'workflows' => [
            'build' => BuildForm::class,
            'query' => QueryForm::class,
            
            'fields' => BuildFields::class,
            'actions' => BuildActions::class,
            'buttons' => BuildButtons::class,
            'sections' => BuildSections::class,
        ],
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
        dd('Test');
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
