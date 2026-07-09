<?php

namespace Streams\Ui\Builders\Images;

use Streams\Ui\Builders\ViewBuilder;
use Illuminate\View\ComponentAttributeBag;
use Streams\Ui\Builders\Concerns as Common;

class Image extends ViewBuilder
{
    use Common\CanBeHidden;
    use Common\HasHtmlAttributes;
    use Common\HasUrl;

    protected string $viewIdentifier = 'image';

    protected string $view = 'ui::builders.image';

    protected string|\Closure|null $src = null;

    protected string|\Closure|null $alt = null;

    protected string|\Closure|null $linkAriaLabel = null;

    protected bool|\Closure $lazy = false;

    /** @var array<int, array<string, mixed>|\Closure> */
    protected array $wrapperHtmlAttributes = [];

    final public function __construct(string|\Closure|null $src = null)
    {
        if (filled($src)) {
            $this->src($src);
        }
    }

    public static function make(string|\Closure|null $src = null): static
    {
        $instance = app(static::class, [
            'src' => $src,
        ]);

        $instance->configure();

        return $instance;
    }

    public function src(string|\Closure $src): static
    {
        $this->src = $src;

        return $this;
    }

    public function getSrc(): ?string
    {
        return $this->evaluate($this->src);
    }

    public function alt(string|\Closure $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getAlt(): string
    {
        $alt = $this->evaluate($this->alt);

        if (blank($alt)) {
            throw new \InvalidArgumentException('Image ['.static::class.'] requires alt text.');
        }

        return $alt;
    }

    public function linkAriaLabel(string|\Closure $label): static
    {
        $this->linkAriaLabel = $label;

        return $this;
    }

    public function getLinkAriaLabel(): ?string
    {
        return $this->evaluate($this->linkAriaLabel);
    }

    public function lazy(bool|\Closure $lazy = true): static
    {
        $this->lazy = $lazy;

        return $this;
    }

    public function isLazy(): bool
    {
        return (bool) $this->evaluate($this->lazy);
    }

    public function mergeWrapperHtmlAttributes(array|\Closure $attributes): static
    {
        $this->wrapperHtmlAttributes[] = $attributes;

        return $this;
    }

    public function getWrapperHtmlAttributes(): array
    {
        $attributes = new ComponentAttributeBag;

        foreach ($this->wrapperHtmlAttributes as $wrapperHtmlAttributes) {
            $attributes = $attributes->merge($this->evaluate($wrapperHtmlAttributes), false);
        }

        return $attributes->getAttributes();
    }

    public function getWrapperHtmlAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getWrapperHtmlAttributes());
    }
}
