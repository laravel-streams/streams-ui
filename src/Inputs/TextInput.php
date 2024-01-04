<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Traits;

class TextInput extends Input
{
    use Traits\HasMask;
    use Traits\HasStep;
    use Traits\HasType;
    use Traits\HasDatalist;
    use Traits\HasInputMode;
    use Traits\HasPlaceholder;

    use Traits\CanBeAutocompleted;
    use Traits\CanBeValueConstrained;
    use Traits\CanBeLengthConstrained;

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
