<?php

namespace Anomaly\Streams\Ui\Form;

use Anomaly\Streams\Ui\Form\Form;
use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Form\Command\SaveForm;
use Anomaly\Streams\Ui\Form\Workflows\BuildForm;
use Anomaly\Streams\Ui\Form\Workflows\QueryForm;
use Anomaly\Streams\Ui\Form\Workflows\ValidateForm;
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

    public function getHandlerAttribute()
    {
        return function ($builder) {
            
            $entry = $builder->instance->entry;

            foreach ($builder->instance->values as $field => $value) {
                $entry->{$field} = $value;
            }

            $builder->instance->stream->repository()->save($entry);

            $builder->entry = $builder->instance->entry = $entry;
        };
    }

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

        'workflows' => [
            'build' => BuildForm::class,
            'query' => QueryForm::class,
            'fields' => BuildFields::class,
            'actions' => BuildActions::class,
            'buttons' => BuildButtons::class,
            'sections' => BuildSections::class,
            'validate' => ValidateForm::class,
        ],
    ];

    public function validate(): Builder
    {
        $workflow = $this->workflow('validate');

        $this->fire('validating', [
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $workflow->process([
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $this->fire('validated', ['builder' => $this]);

        return $this;
    }

    //---------------------------------------------------------------------
    //-------------------------    Old Shit    ----------------------------
    //---------------------------------------------------------------------

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
