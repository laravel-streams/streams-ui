<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Components\Workflows\FormBuilder;

class Form extends Component
{
    use HasStream;
    use HasAttributes;

    public ?string $builder = FormBuilder::class;

    public string $template = 'ui::components.form';

    public string $handle = 'default';

    public string $enctype = 'multipart/form-data';

    public ?string $action = null;

    public string $method = 'POST';

    public array $rules = [];
    public array $fields = [];
    public array $buttons = [];

    public ?string $stream = null;

    public $entry = null;

    public array $attributes = [];

    public function save()
    {
        if ($stream = $this->stream()) {
            $rules = $stream->rules();
        }

        $keys = array_keys($rules);

        $rules = array_combine(array_map(function($key) {
            return 'entry.' . $key;
        }, $keys), $rules);

        $result = $stream->validator($rules);

        if ($result->fails()) {
            foreach ($result->messages()->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }

            return;
        }

        if ($this->entry) {
            
        }
    }
}
