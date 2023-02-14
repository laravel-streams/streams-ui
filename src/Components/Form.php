<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Traits\HasAttributes;

class Form extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.form';
    
    public string $handle = 'default';

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

        if (!$this->stream || !$stream = $this->stream()) {
            return;
        }

        $this->fields = $stream->fields->toArray() ?: [];

        foreach ($this->fields as $id => &$field) {
            $field['entry'] = $this->entry;
            $field['stream'] = $this->stream;
            $field['field'] = $id;
        }


        $this->buttons = $this->buttons ?: [
            [
                'type' => 'submit',
                'text' => 'Submit',
            ],
            [
                'tag' => 'a',
                'type' => null,
                'text' => 'Cancel',
                'url' => '/' . Request::segment(1) . '/' . Request::segment(2),
            ],
        ];
    
    
        $entry = $stream?->repository()->find($this->entry);

        $forms = new Collection(Arr::get($this->stream()?->ui, 'forms', []));

        $form = $forms->where('handle', $this->handle)->first();

        if ($form && isset($form['buttons'])) {
            $this->buttons = array_merge($this->buttons, $form['buttons']);
        }

        // Load form values from the entry.
        if ($stream && $entry) {
            
            foreach ($this->fields as $i => &$field) {
                $this->fields[$i]['input']['value'] = $entry->{$field['field']};
            }
        }
    }
}
