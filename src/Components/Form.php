<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
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

    public $entry = null;

    public array $attributes = [];

    public function booted()
    {
        $this->stream = Request::segment(2);
        $this->entry = Request::segment(3);

        $this->fields = $this->stream()->fields->toArray();

        foreach ($this->fields as $id => &$field) {
            $field['entry'] = $this->entry;
            $field['stream'] = $this->stream;
            $field['field'] = $id;
        }

        $stream = $this->stream();
    
        $entry = $stream?->repository()->find($this->entry);

        // Load form values from the entry.
        if ($stream && $entry) {
            
            foreach ($this->fields as $i => &$field) {
                $this->fields[$i]['input']['value'] = $entry->{$field['field']};
            }
        }

        $this->buttons = $this->buttons ?: [
            [
                'type' => 'submit',
                'text' => 'Submit',
            ],
        ];
    }
}
