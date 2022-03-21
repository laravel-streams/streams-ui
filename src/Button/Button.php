<?php

namespace Streams\Ui\Button;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Support\Traits\HasAttributes;

/**
 * @typescript
 * @property string $template  default is 'ui::buttons.button',
 * @property string $tag  default is 'a',
 * @property string $url  default is null,
 * @property mixed $text  default is null,
 * @property mixed $entry  default is null,
 * @property mixed $policy  default is null,
 * @property bool $enabled  default is true,
 * @property bool $primary  default is false,
 * @property bool $disabled  default is false,
 * @property string $type  default is 'default',
 * @property array<string> $classes  default is []
 * @property array $attributes  default is [],
 */
class Button extends Component
{
    use HasAttributes;

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeComponentPrototype(array $attributes)
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'button',
            'template'  => 'ui::buttons.button',

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

    /**
     * Return the open tag.
     *
     * @param array $attributes
     * @return string
     */
    public function open(array $attributes = [])
    {
        $attributes = Arr::htmlAttributes($this->attributes($attributes));

        return '<' . $this->tag . $attributes . '>';
    }

    /**
     * Return the close tag.
     *
     * @return string
     */
    public function close()
    {
        return '</' . $this->tag . '>';
    }

    /**
     * Return the button attributes array.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_filter(array_merge([
            'name'  => $this->name,
            'value' => $this->value,
            'class' => $this->class(),
            'href' => $this->url(),
        ], $attributes)));
    }

    public function text()
    {
        if ($this->text === false) {
            return null;
        }

        if ($this->text === null) {
            $this->text = Str::title(Str::humanize($this->handle));
        }

        return $this->text;
    }

    public function url(array $extra = [])
    {
        if (!$target = Arr::get($this->attributes, 'href')) {
            return null;
        }

        return URL::to(Str::parse($target));
    }

    public function onInitializing($callbackData)
    {
        $attributes = $callbackData->get('attributes');

        $this->initializeAttributesAttribute($attributes);

        $callbackData->put('attributes', $attributes);
    }
}
