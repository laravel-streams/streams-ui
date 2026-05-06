<?php

namespace Streams\Ui\Builders\Inputs;

class TextInput extends Input
{
    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeLengthConstrained;
    use Concerns\CanBeValueConstrained;
    use Concerns\HasDatalist;
    use Concerns\HasInputMode;
    use Concerns\HasMask;
    use Concerns\HasPlaceholder;
    use Concerns\HasPrefix;
    use Concerns\HasStep;
    use Concerns\HasSuffix;
    use Concerns\HasType;

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
