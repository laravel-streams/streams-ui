<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Tags extends Input
{
    public string $template = 'ui::components.inputs.tags';

    public function post()
    {
        parent::post();

        $this->value = explode(',', $this->value);

        return $this;
    }
}
