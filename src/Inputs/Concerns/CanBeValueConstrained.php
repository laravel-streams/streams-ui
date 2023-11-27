<?php

namespace Streams\Ui\Inputs\Concerns;

trait CanBeValueConstrained
{
    protected $maxValue = null;

    protected $minValue = null;

    public function maxValue($value): static
    {
        $this->maxValue = $value;

        $this->rule(
            static function (
                // TextInput
                $component
            ): string {

                $value = $component->getMaxValue();

                return "max:{$value}";
            },
            static fn (
                // TextInput
                $component
            ): bool => filled($component->getMax())
        );

        return $this;
    }

    public function minValue($value): static
    {
        $this->minValue = $value;

        $this->rule(
            static function (
                // TextInput
                $component
            ): string {

                $value = $component->getMinValue();

                return "min:{$value}";
            },
            static fn (
                // TextInput
                $component
            ): bool => filled($component->getMinValue())
        );

        return $this;
    }

    public function getMaxValue()
    {
        return $this->evaluate($this->maxValue);
    }

    public function getMinValue()
    {
        return $this->evaluate($this->minValue);
    }
}
