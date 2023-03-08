<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Streams\Core\Support\Facades\Messages;
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
        if (!$stream = $this->stream()) {
            throw new \Exception('No stream defined.');
        }
        
        $result = $stream->validator(
            $data = Arr::except(
                Request::post(),
                array_filter(array_keys($_POST), fn ($key) => substr($key, 0, 1) == '_')
            ),
            $this->entry
        );

        if (!$result->passes()) {

            dd($result->messages()->messages());

            return Redirect::back();
        }

        if ($this->entry) {
            $entry = $this->entry()->fill($data);
        } else {
            $entry = $stream->repository()->newInstance($data);
        }

        $entry->save();

        Messages::success('Saved!');

        $parts = explode('/', trim(parse_url(URL::previous(), PHP_URL_PATH), '/'));

        return Redirect::to($parts[0] . '/' . $parts[1]);
        //return Redirect::to($parts[0] . '/' . $parts[1] . '/' . $parts[2] . '/' . $entry->id);
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
