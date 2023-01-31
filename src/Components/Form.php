<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Redirect;

class Form extends Component
{
    public string $template = 'ui::components.form';

    public array $fields = [];

    public function submit()
    {
        return Redirect::to('/ui?success=true');
    }

    public function booted()
    {
        if ($this->stream) {

            foreach ($this->fields as &$field) {

                $field['stream'] = $this->stream;

                if (!isset($field['handle'])) {
                    $field['handle'] = $field['field'];
                }
            }
        }
    }
}
