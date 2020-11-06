<?php

namespace Streams\Ui\Form;

use Streams\Ui\Form\Form;
use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Illuminate\Support\Facades\App;
use Streams\Ui\Form\Command\SaveForm;
use Streams\Ui\Form\Workflows\BuildForm;
use Streams\Ui\Form\Workflows\QueryForm;
use Streams\Core\Support\Facades\Resolver;
use Streams\Core\Support\Facades\Evaluator;
use Streams\Ui\Form\Workflows\ValidateForm;
use Streams\Core\Repository\Contract\RepositoryInterface;
use Streams\Ui\Form\Component\Field\Workflows\BuildFields;
use Streams\Ui\Form\Component\Action\Workflows\BuildActions;
use Streams\Ui\Form\Component\Button\Workflows\BuildButtons;
use Streams\Ui\Form\Component\Section\Workflows\BuildSections;

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
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'async' => false,
            'handler' => null,
            'read_only' => false,

            'stream' => null,
            'repository' => null,

            'entry' => null,

            'rules' => [],
            'validators' => [],

            'fields' => [],
            'assets' => [],
            'actions' => [],
            'buttons' => [],
            'sections' => [],

            'options' => [],

            'component' => 'form',
            'form' => Form::class,

            'steps' => [
                'make_component' => [$this, 'make'],

                'query_entry' => [$this, 'queryEntry'],

                'authorize_form' => [$this, 'authorizeForm'],

                'set_validation' => [$this, 'setValidation'],

                'build_fields' => [$this, 'buildFields'],
                'build_actions' => [$this, 'buildActions'],
                'build_buttons' => [$this, 'buildButtons'],
                'build_sections' => [$this, 'buildSections'],

                'load_values' => [$this, 'loadValues'],

                'validate_form' => [$this, 'validateForm'],
                'flash_messages' => [$this, 'flashMessages'],

                'handle_request' => [$this, 'handleRequest'],
            ],

            'workflows' => [
                //'build' => BuildForm::class,
                'query' => QueryForm::class,
                'fields' => BuildFields::class,
                'actions' => BuildActions::class,
                'buttons' => BuildButtons::class,
                'sections' => BuildSections::class,
                'validate' => ValidateForm::class,
            ],
        ], $attributes));
    }

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
     * Return the repository.
     *
     * @return RepositoryInterface
     */
    public function repository()
    {
        if ($this->repository instanceof RepositoryInterface) {
            return $this->repository;
        }

        /**
         * Default to configured.
         */
        if ($this->repository) {
            return $this->repository = App::make($this->repository, [
                'builder' => $this,
            ]);
        }

        /**
         * Fallback for Streams.
         */
        if (!$this->repository && $this->stream instanceof Stream) {
            return $this->repository = $this->stream->repository();
        }

        return null;
    }

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

    public function queryEntry()
    {
        /*
         * If the builder has an entry handler
         * then call it through the container and
         * let it load the entry itself.
         */
        if (
            (is_string($this->entry) && class_exists($this->entry))
            || $this->entry instanceof \Closure
        ) {

            $entry = Resolver::resolve($this->entry, compact('builder'));

            $this->entry = Evaluator::evaluate($entry ?: $this->entry, compact('builder'));

            return;
        }

        /**
         * If the builder already has
         * an entry then just use that.
         */
        if ($this->entry && is_object($this->entry)) {

            $this->instance->entry = $this->entry;

            return;
        }

        /*
         * Fallback to using the repository 
         * to get and/or paginate the results.
         */
        if ($this->repository() instanceof RepositoryInterface) {

            $this->criteria = $this->repository()->newCriteria();

            $this->instance->entry = $this->criteria->find($this->entry);

            return;
        }
    }

    public function authorizeForm(FormAuthorizer $authorizer)
    {
        $authorizer->authorize($this);
    }

    public function setValidation()
    {
        if (!$this->stream) {
            return;
        }

        $rules = array_merge(
            (array) $this->rules,
            (array) $this->stream->rules
        );

        $validators = array_merge(
            (array) $this->validators,
            (array) $this->stream->validators
        );

        $this->instance->rules = $this->rules = $rules;
        $this->instance->validators = $this->validators = $validators;
    }

    public function buildFields()
    {
        dd('Form > Build Fields');
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
