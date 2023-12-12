<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Concerns;

class TextInput extends Input
{
    use Concerns\HasMask;
    use Concerns\HasStep;
    use Concerns\HasType;
    use Concerns\HasDatalist;
    use Concerns\HasInputMode;
    use Concerns\HasPlaceholder;

    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeValueConstrained;
    use Concerns\CanBeLengthConstrained;

    protected string $view = 'ui::builders.inputs.text';

    protected string | \Closure | null $telRegex = null;

    public function telRegex(string | \Closure | null $regex): static
    {
        $this->telRegex = $regex;

        return $this;
    }

    public function getTelRegex(): string
    {
        return $this->evaluate($this->telRegex)
            ?? '/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/';
    }
}
