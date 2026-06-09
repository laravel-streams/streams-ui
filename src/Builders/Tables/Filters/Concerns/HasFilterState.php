<?php

namespace Streams\Ui\Builders\Tables\Filters\Concerns;

use Illuminate\Support\Arr;
use Streams\Ui\Builders\ViewBuilder;

trait HasFilterState
{
    protected array|\Closure|null $defaultState = null;

    public function defaultState(array|\Closure $state): static
    {
        $this->defaultState = $state;

        return $this;
    }

    public function getDefaultState(): array
    {
        return $this->evaluate($this->defaultState) ?? ['value' => null];
    }

    public function getResetState(): array
    {
        return $this->getDefaultState();
    }

    /**
     * @return array<string, mixed>
     */
    public function getState(): array
    {
        return $this->getTable()->getFilterState($this->getName());
    }

    public function getValue(): mixed
    {
        return Arr::get($this->getState(), 'value');
    }

    public function isActive(): bool
    {
        return filled($this->getValue());
    }

    /**
     * @return array<int, ViewBuilder>
     */
    public function getFormSchema(): array
    {
        return $this->getComponents();
    }

    public function getIndicatorLabel(): string
    {
        if (method_exists($this, 'getLabel') && filled($label = $this->getLabel())) {
            return $label;
        }

        return strval($this->getName());
    }

    public function getIndicatorValue(): string
    {
        $value = $this->getValue();

        if ($value === null || $value === '') {
            return '';
        }

        if (method_exists($this, 'getOptions')) {
            $options = $this->getOptions();

            if (is_array($options) && array_key_exists($value, $options)) {
                return strval($options[$value]);
            }
        }

        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        return strval($value);
    }
}
