<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Core\Validation\StreamsPresenceVerifier;

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

    public function validator($data, bool $fresh = true): Validator
    {
        if ($this->stream && $validator = $this->stream()?->validator($data)) {
            return $validator;
        }

        $data = Arr::make($data);

        $factory = App::make(Factory::class);

        $keyName = 'id';

        $factory->setPresenceVerifier(new StreamsPresenceVerifier(App::make('db')));

        foreach ($this->validators ?: [] as $rule => $validator) {

            $handler = Arr::get($validator, 'handler');

            $factory->extend(
                $rule,
                function ($attribute, $value, $parameters, Validator $validator) use ($handler) {

                    $field = $this->stream()?->fields->get($attribute);
        
                    return App::call(
                        $handler,
                        [
                            'field' => $field,
                            'value' => $value,
                            'attribute' => $attribute,
                            'validator' => $validator,
                            'parameters' => $parameters,
                            'stream' => $this->stream(),
                        ]
                    );
                },
                Arr::get($validator, 'message')
            );
        }

        array_walk($this->rules, function (&$rules, $field) use ($fresh, $data, $keyName) {

            foreach ($rules as &$rule) {

                /**
                 * Automate unique options.
                 */
                if (Str::startsWith($rule, 'unique')) {

                    $parts = explode(':', $rule);
                    $parameters = array_filter(explode(',', Arr::get($parts, 1)));

                    if (!$parameters) {
                        $parameters[] = $this->id;
                    }

                    if (count($parameters) === 1) {
                        $parameters[] = $field;
                    }

                    if (!$fresh && $key = Arr::get($data, $keyName)) {
                        $parameters[] = $key;
                        $parameters[] = $keyName;
                    }

                    $rule = 'unique:' . implode(',', $parameters);
                }

                if (strpos($rule, '\\')) {
                    $rule = new $rule;
                }
            }
        });

        return $factory->make($data, $this->rules);
    }
}
