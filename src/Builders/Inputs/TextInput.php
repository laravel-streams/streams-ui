<?php

namespace Streams\Ui\Builders\Inputs;

class TextInput extends Input
{
    use Traits\CanBeAutocompleted;
    use Traits\CanBeLengthConstrained;
    use Traits\CanBeValueConstrained;
    use Traits\HasDatalist;
    use Traits\HasInputMode;
    use Traits\HasMask;
    use Traits\HasPlaceholder;
    use Traits\HasPrefix;
    use Traits\HasStep;
    use Traits\HasSuffix;
    use Traits\HasType;

    protected string $view = 'ui::builders.inputs.text';

    protected string|\Closure|null $telRegex = null;

    public function telRegex(string|\Closure|null $regex): static
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
