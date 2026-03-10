<?php

namespace Streams\Ui\Builders\Concerns;

trait HasTitle
{
    // public static function getTitle(): string
    // {
    //     return static::$title ?? (string) str(class_basename(static::class))
    //         ->kebab()
    //         ->replace('-', ' ')
    //         ->title();
    // }

    protected string|\Closure|null $title = null;

    public function title(string|\Closure|null $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->evaluate($this->title);
    }
}
