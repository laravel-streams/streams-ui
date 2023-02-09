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
        // Builder?
    }
}
