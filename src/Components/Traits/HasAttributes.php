<?php

namespace Streams\Ui\Components\Traits;

use Collective\Html\HtmlFacade;

trait HasAttributes
{
    public function attributesArray(array $attributes = []): array
    {
        $attributes = array_merge_recursive($this->htmlAttributes, $attributes);

        if (array_key_exists('class', $attributes)) {
            $attributes['class'] = $this->classAttribute((array) $attributes['class']);
        }

        return $attributes;
    }

    public function htmlAttributes(array $attributes = []): string
    {
        return HtmlFacade::attributes($this->attributesArray($attributes));
    }

    protected function classAttribute(array $class = []): string
    {
        foreach ($class as $i => $value) {

            if (is_bool($value) && !$value) {
                unset($class[$i]);
            }

            if (is_bool($value) && $value) {
                $class[$i] = $i;
            }
        }

        return implode(' ', array_unique($class));
    }
}
