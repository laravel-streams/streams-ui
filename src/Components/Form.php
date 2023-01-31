<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
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

            /**
             * Default to all stream fields.
             */
            if (!$this->fields) {
                $this->fields = $this->stream()->fields->keys()->map(function($value) {
                    return ['field' => $value];
                })->toArray();
            }

            foreach ($this->fields as &$field) {

                // Ensure stream is set if available.
                $field['stream'] = Arr::get($field, 'stream', $this->stream);

                // Default handle to field.
                if (!isset($field['handle'])) {
                    $field['handle'] = $field['field'];
                }
            }
        }
    }
}
