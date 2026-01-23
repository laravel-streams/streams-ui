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
        $fieldRules = $this->resolveInputRules($this->getComponents());
        
        $rules = array_merge($fieldRules, $this->validationRules, $rules);

        $data = $this->getDataForValidation($rules);

        // $data = $this->unwrapDataForValidation($data);
        
        $validator = Validator::make($data, $rules, $messages, $attributes);

        $validatedData = $validator->validate();
        
        $this->resetErrorBag();

        return $validatedData;
    }

    protected function resolveInputRules(array $components): array
    {
        $rules = [];

        foreach ($components as $component) {

            if ($component instanceof Input) {
                $rules = array_merge($rules, [
                    $component->getStatePath() => $component->getValidationRules()
                ]);
            }

            if (method_exists($component, 'getComponents')) {
                $rules = array_merge($rules, $this->resolveInputRules($component->getComponents()));
            }
        }

        return $rules;
    }

    protected function getDataForValidation(array $rules): array
    {
        return $this->livewire->data;
    }
}
