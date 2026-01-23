<?php

namespace Streams\Ui\Builders\Forms\Concerns;

use Streams\Ui\Builders\Inputs\Input;
use Illuminate\Support\Facades\Validator;

trait HandlesValidation
{
    protected array $validationRules = [];

    public function validationRules(array $rules): static
    {
        $this->validationRules = $rules;

        return $this;
    }

    public function validate(array $rules = [], array $messages = [], array $attributes = [])
    {
        $fieldRules = $this->resolveFieldRules($this->getComponents());
        dd($fieldRules);
        $rules = array_merge($this->validationRules, $rules);
        
        $data = $this->getDataForValidation($rules);

        // $data = $this->unwrapDataForValidation($data);
dd($rules);
        $validator = Validator::make($data, $rules, $messages, $attributes);

        if ($this->withValidatorCallback) {
            call_user_func($this->withValidatorCallback, $validator);

            $this->withValidatorCallback = null;
        }

        $this->shortenModelAttributesInsideValidator($ruleKeysToShorten, $validator);

        $customValues = $this->getValidationCustomValues();

        if (! empty($customValues)) {
            $validator->addCustomValues($customValues);
        }

        if ($this->isRootComponent() && $isUsingGlobalRules) {
            $validatedData = $this->withFormObjectValidators($validator, fn () => $validator->validate(), fn ($form) => $form->validate());
        } else {
            $validatedData = $validator->validate();
        }

        $this->resetErrorBag();

        return $validatedData;
    }

    protected function resolveFieldRules(array $components): array
    {
        $rules = [];

        foreach ($components as $component) {
            
            if ($component instanceof Input) {
                $rules = array_merge($rules, $component->getValidationRules());
            }

            if (method_exists($component, 'getComponents')) {
                $rules = array_merge($rules, $this->resolveFieldRules($component->getComponents()));
            }
        }

        return $rules;
    }

    protected function getDataForValidation(array $rules): array
    {
        return $this->livewire->data;
    }
}
