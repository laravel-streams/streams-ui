<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Form extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.form';

    public string $enctype = 'multipart/form-data';

    public ?string $action = null;

    public string $method = 'GET';

    public array $rules = [];
    public array $validators = [];

    public array $fields = [];
    public array $buttons = [];

    public array $attributes = [];

    public function boot()
    {
        if ($this->stream) {

            /**
             * Default to all stream fields.
             */
            if (!$this->fields) {
                $this->fields = $this->stream()->fields->keys()->map(function ($value) {
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

                // Default name to handle.
                if (!isset($field['name'])) {
                    $field['name'] = $field['handle'];
                }
            }
        }
    }
}
