<?php

namespace Streams\Ui\Traits;

use Streams\Ui\Forms\Form;
use Livewire\WithFileUploads;
use Streams\Ui\Exceptions\ValidationException;

trait InteractsWithForms
{
    // use HasFormComponentActions;
    // use ResolvesDynamicLivewireProperties;
    use WithFileUploads;

    protected bool $hasFormsModalRendered = false;

    protected array $oldFormState = [];

    public function dispatchFormEvent(mixed ...$args): void
    {
        foreach ($this->getForms() as $form) {
            $form->dispatchEvent(...$args);
        }
    }

    public function validate($rules = null, $messages = [], $attributes = []): array
    {
        try {
            return parent::validate($rules, $messages, $attributes);
        } catch (ValidationException $exception) {

            $this->onValidationError($exception);

            throw $exception;
        }
    }

    protected function onValidationError(ValidationException $exception): void
    {
    }

    public function validateField($field, $rules = null, $messages = [], $attributes = [], $dataOverrides = [])
    {
        try {
            return parent::validateField($field, $rules, $messages, $attributes, $dataOverrides);
        } catch (ValidationException $exception) {

            $this->onValidationError($exception);

            throw $exception;
        }
    }

    public function getForm(string $name): ?Form
    {
        return $this->getForms()[$name] ?? null;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form($this->makeForm()),
        ];
    }

    public function form(Form $form): Form
    {
        return $form;
        // ->schema($this->getFormSchema())
        // ->model($this->getFormModel())
        // ->statePath($this->getFormStatePath())
        // ->operation($this->getFormContext());
    }

    public function getRules(): array
    {
        $rules = parent::getRules();

        foreach ($this->getForms() as $form) {
            $rules = [
                ...$rules,
                ...$form->getValidationRules(),
            ];
        }

        return $rules;
    }

    protected function makeForm(): Form
    {
        return Form::make($this);
    }
}
