<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Workflows\SaveForm;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Components\Workflows\FormBuilder;

class Form extends Component
{
    use HasStream;
    use HasAttributes;

    public ?string $builder = FormBuilder::class;

    public string $template = 'ui::components.form';

    public string $enctype = 'multipart/form-data';

    public ?string $action = null;

    public string $method = 'POST';

    public array $rules = [];
    public array $fields = [];
    public array $buttons = [];

    public array $errors = [];

    public ?string $stream = null;

    public $entry = null;

    public array $attributes = [];

    public function validate(): bool
    {
        $rules = $this->rules;

        $data = Arr::except(
            Request::post(),
            array_filter(array_keys($_POST), fn ($key) => substr($key, 0, 1) == '_')
        );

        $result = Validator::make($data, $rules);

        if (!$result->passes()) {
            
            $this->errors = $result->messages()->messages();

            return false;
        }

        return true;
    }

    public function save()
    {
        $this->validate();

        if ($this->errors) {
            return Redirect::back();
        }

        $this->fire('saving', [
            'component' => $this,
        ]);

        (new SaveForm)
            ->passThrough($this)
            ->process([
                'component' => $this,
            ]);

        $this->fire('saved', [
            'component' => $this,
        ]);

        $parts = array_filter(explode('/', trim(parse_url(URL::previous(), PHP_URL_PATH), '/')));

        if ($this->errors) {
            return Redirect::back();
        } elseif ($parts) {
            return Redirect::to($parts[0] . '/' . $parts[1] . '/' . $this->entry . '/' . ($parts[3] ?? 'edit'));
        } else {
            return Redirect::to('admin/' . $this->stream . '/' . $this->entry . '/edit');
        }
    }

    public function entry(): object|null
    {
        if (!$this->stream) {
            return null;
        }

        $key = __METHOD__ . '.' . $this->stream . '.' . $this->entry;

        return $this->once($key, fn ()  => $this->stream()->repository()->find($this->entry));
    }
}
