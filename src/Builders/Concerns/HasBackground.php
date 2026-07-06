<?php

namespace Streams\Ui\Builders\Concerns;

trait HasBackground
{
    /**
     * @var array<string, string|\Closure|null>|null|\Closure
     */
    protected array|\Closure|null $background = null;

    /**
     * @param  array{
     *     image?: string|\Closure|null,
     *     repeat?: string|\Closure|null,
     *     size?: string|\Closure|null,
     *     position?: string|\Closure|null,
     *     attachment?: string|\Closure|null,
     * }|string|\Closure|null  $image
     */
    public function background(
        array|string|\Closure|null $image = null,
        string|\Closure|null $repeat = null,
        string|\Closure|null $size = null,
        string|\Closure|null $position = null,
        string|\Closure|null $attachment = null,
    ): static {
        if ($image instanceof \Closure && func_num_args() === 1) {
            $this->background = $image;

            return $this;
        }

        if (is_array($image)) {
            return $this->applyBackgroundOptions($image);
        }

        return $this->applyBackgroundOptions(array_filter([
            'image' => $image,
            'repeat' => $repeat,
            'size' => $size,
            'position' => $position,
            'attachment' => $attachment,
        ], static fn (mixed $value): bool => $value !== null));
    }

    public function backgroundImage(string|\Closure|null $image): static
    {
        return $this->setBackgroundOption('image', $image);
    }

    public function backgroundRepeat(string|\Closure|null $repeat): static
    {
        return $this->setBackgroundOption('repeat', $repeat);
    }

    public function backgroundSize(string|\Closure|null $size): static
    {
        return $this->setBackgroundOption('size', $size);
    }

    public function backgroundPosition(string|\Closure|null $position): static
    {
        return $this->setBackgroundOption('position', $position);
    }

    public function backgroundAttachment(string|\Closure|null $attachment): static
    {
        return $this->setBackgroundOption('attachment', $attachment);
    }

    /**
     * @return array{
     *     image?: string,
     *     repeat?: string,
     *     size?: string,
     *     position?: string,
     *     attachment?: string,
     * }|null
     */
    public function getBackground(): ?array
    {
        $background = $this->evaluate($this->background);

        if (! is_array($background) || $background === []) {
            return null;
        }

        $resolved = [];

        foreach ($background as $property => $value) {
            $resolvedValue = $this->evaluate($value);

            if (filled($resolvedValue)) {
                $resolved[$property] = (string) $resolvedValue;
            }
        }

        return $resolved === [] ? null : $resolved;
    }

    public function hasBackground(): bool
    {
        return $this->getBackground() !== null;
    }

    /**
     * @return list<string>
     */
    public function getBackgroundStyles(): array
    {
        $background = $this->getBackground();

        if ($background === null) {
            return [];
        }

        $styles = [];

        if (isset($background['image'])) {
            $styles[] = 'background-image: url('.$this->quoteCssUrl($background['image']).')';
        }

        foreach (['repeat', 'size', 'position', 'attachment'] as $property) {
            if (isset($background[$property])) {
                $styles[] = 'background-'.$property.': '.$background[$property];
            }
        }

        return $styles;
    }

    /**
     * @param  array<string, string|\Closure|null>  $options
     */
    protected function applyBackgroundOptions(array $options): static
    {
        foreach ($options as $property => $value) {
            if ($value !== null) {
                $this->setBackgroundOption($property, $value);
            }
        }

        return $this;
    }

    protected function setBackgroundOption(string $property, string|\Closure|null $value): static
    {
        if ($this->background instanceof \Closure) {
            $evaluated = $this->evaluate($this->background);

            $this->background = is_array($evaluated) ? $evaluated : [];
        }

        if (! is_array($this->background)) {
            $this->background = [];
        }

        $this->background[$property] = $value;

        return $this;
    }

    protected function quoteCssUrl(string $url): string
    {
        return "'".str_replace("'", "\\'", $url)."'";
    }
}
