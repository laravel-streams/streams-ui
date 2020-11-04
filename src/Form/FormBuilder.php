<?php

namespace Streams\Ui\Form;

use Streams\Ui\Form\Form;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Illuminate\Support\Facades\App;
use Streams\Ui\Form\Command\SaveForm;
use Streams\Ui\Form\Workflows\BuildForm;
use Streams\Ui\Form\Workflows\QueryForm;
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

            'workflows' => [
                'build' => BuildForm::class,
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
