<?php

namespace Streams\Ui\Support\Traits;

use Streams\Ui\Support\Normalizer;

trait HasDropdown
{

    public function setDropdownAttribute($dropdown)
    {
        $dropdown = Normalizer::attributes($dropdown);

        $this->setPrototypeAttributeValue('dropdown', $dropdown);
    }
}
