<?php

namespace Streams\Ui\Actions\Traits;

use Streams\Ui\Forms\Form;

trait HasForm
{
    protected array $formData = [];

    protected array | \Closure | null $form = null;

    protected bool | \Closure $isFormDisabled = false;

    protected ?\Closure $mutateFormDataUsing = null;

    public function disabledForm(bool | \Closure $condition = true): static
    {
        $this->isFormDisabled = $condition;

        return $this;
    }

    public function form(array | \Closure | null $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function getForm(Form $form): ?Form
    {
        $modifiedForm = $this->evaluate($this->form, [
            'form' => $form,
        ]);

        if ($modifiedForm === null) {
            return null;
        }

        if (is_array($modifiedForm) && (! count($modifiedForm))) {
            return null;
        }

        if (is_array($modifiedForm) && $this->isWizard()) {
            $modifiedForm = [
                Wizard::make($modifiedForm)
                    ->contained(false)
                    ->startOnStep($this->getWizardStartStep())
                    ->cancelAction($this->getModalCancelAction())
                    ->submitAction($this->getModalSubmitAction())
                    ->skippable($this->isWizardSkippable())
                    ->disabled($this->isFormDisabled()),
            ];
        }

        if (is_array($modifiedForm)) {
            $modifiedForm = $form->components($modifiedForm);
        }

        if ($this->isFormDisabled()) {
            return $modifiedForm->disabled();
        }

        return $modifiedForm;
    }

    public function mutateFormDataUsing(?\Closure $callback): static
    {
        $this->mutateFormDataUsing = $callback;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function formData(array $data, bool $shouldMutate = true): static
    {
        if ($shouldMutate && $this->mutateFormDataUsing) {
            $data = $this->evaluate($this->mutateFormDataUsing, [
                'data' => $data,
            ]);
        }

        $this->formData = $data;

        return $this;
    }

    public function resetFormData(): static
    {
        $this->formData([], shouldMutate: false);

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

    public function isFormDisabled(): bool
    {
        return (bool) $this->evaluate($this->isFormDisabled);
    }
}
