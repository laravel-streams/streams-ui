<?php

namespace Streams\Ui\Traits;

trait HasTitle
{
    protected static ?string $title = null;

    static public function getTitle(): string
    {
        return static::$title ?? (string) str(class_basename(static::class))
            ->kebab()
            ->replace('-', ' ')
            ->title();
    }
}
