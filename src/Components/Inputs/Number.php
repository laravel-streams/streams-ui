<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Number extends Input
{
    public string $template = 'ui::components.input.number';

    public string $type = 'number';

    public function htmlAttributes(array $attributes = [])
    {
        return parent::htmlAttributes(array_merge([
            'min' => $this->field?->ruleParameter('min'),
            'max' => $this->field?->ruleParameter('max'),
        ], $attributes));
    }
}
