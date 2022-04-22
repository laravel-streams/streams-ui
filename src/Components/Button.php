<?php

namespace Streams\Ui\Components;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;

class Button extends Component
{
    public string $component = 'button';
    public string $template = 'ui::components.button';

    public ?object $entry = null;

    public string $tag = 'a';
    public ?string $url = null;
    public ?string $text = null;
    public ?string $policy = null;
    
    public bool $enabled = true;
    public bool $primary = false;
    public bool $disabled = false;
    
    public string $type = 'default';

    public $classes = [
        'a-button',
    ];
    
    public function open(array $attributes = []): string
    {
        $attributes = $this->htmlAttributes($attributes);

        return '<' . $this->tag . $attributes . '>';
    }

    public function close(): string
    {
        return '</' . $this->tag . '>';
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_filter(array_merge([
            'entry'  => null,
            'name'  => $this->name,
            'value' => $this->handle,
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
        if (!$target = Arr::get($this->attributes, 'url')) {
            $target = Arr::get($this->attributes, 'href');
        }

        return $target ? URL::to(Str::parse($target, [
            'entry' => $this->entry,
            'stream' => $this->stream,
        ])) : null;
    }
}
