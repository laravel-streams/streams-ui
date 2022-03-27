<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;

class Button extends Component
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'button',
            'template'  => 'ui::components.button',

            'tag'      => 'a',
            'url'      => null,
            'text'     => null,
            'entry'    => null,
            'policy'   => null,
            'enabled'  => true,
            'primary'  => false,
            'disabled' => false,
            'type'     => 'default',
            'classes'  => [
                'a-button',
            ],
            'attributes' => [],
        ], $attributes));
    }

    public function open(array $attributes = []): string
    {
        $attributes = Arr::htmlAttributes($this->attributes($attributes));

        return '<' . $this->tag . $attributes . '>';
    }

    public function close(): string
    {
        return '</' . $this->tag . '>';
    }

    public function attributes(array $attributes = []): array
    {
        return parent::attributes(array_filter(array_merge([
            'entry'  => null,
            'name'  => $this->name,
            'value' => $this->value,
            'class' => $this->class(),
            'href' => $this->url(),
        ], $attributes)));
    }

    public function text(): string|null
    {
        if ($this->text === false) {
            return null;
        }

        if ($this->text === null) {
            $this->text = Str::title(Str::humanize($this->handle));
        }

        return $this->text;
    }

    public function url(array $extra = []): string|null
    {
        if (!$target = $this->attributes->get('url')) {
            $target = $this->attributes->get('href');
        }

        return $target ? URL::to(Str::parse($target, [
            'entry' => $this->entry,
            'stream' => $this->stream,
        ])) : null;
    }
}
