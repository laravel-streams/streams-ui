<?php

namespace Streams\Ui\Builders\Actions;

use Livewire\Component;
use Illuminate\Support\Str;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Actions;
use Streams\Ui\Builders\Concerns as Common;

class Action extends ViewBuilder
{
    use Common\BelongsToLivewire;
    use Common\CanBeDisabled;
    use Common\CanBeHidden;
    use Common\HasBadge;
    use Common\HasBorderRadius;
    use Common\HasColor;
    use Common\HasEntry;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasLoadingIndicator;
    use Common\HasName;
    use Common\HasSize;
    use Common\HasTooltip;
    use Common\HasUrl;
    use Concerns\HasArguments;
    use Concerns\HasForm;
    use Concerns\HasKeyBindings;
    use Concerns\HasStyle;
    use Concerns\HasTag;

    // use Concerns\CanBeLabeledFrom;
    // use Concerns\CanBeOutlined;

    protected string $view = 'ui::builders.action';

    protected string $viewIdentifier = 'action';

    protected string $evaluationIdentifier = 'action';

    public function __construct(string $name)
    {
        $this->name($name);

        $this->id(Str::slug($name));
    }

    public static function make(?string $name = null): static
    {
        $name = $name ?? self::getDefaultName();

        $static = new static($name);

        $static->configure();

        return $static;
    }

    public static function for(Component $livewire, ?string $name = null): static
    {
        $resolvedName = $name ?? static::getDefaultName();

        $static = new static($resolvedName);

        if (method_exists($static, 'livewire')) {
            $static->livewire($livewire);
        }

        $static->configure();

        return $static;
    }

    public static function register(?Component $livewire = null, ?string $name = null): void
    {
        $name = $name ?? self::getDefaultName();

        Actions::register(
            $name,
            fn () => $livewire ? static::for($livewire, $name) : static::make($name),
        );
    }

    public static function resolve(?string $name = null): ?static
    {
        $name = $name ?? self::getDefaultName();

        return Actions::resolve($name);
    }

    public function href(
        string|\Closure|null $url = null,
        bool|\Closure $openInNewTab = false
    ): static {
        $this->tag('a');
        $this->url($url, $openInNewTab);

        return $this;
    }

    public function link(
        string|\Closure|null $url = null,
        bool|\Closure $openInNewTab = false
    ): static {
        $this->style(__FUNCTION__);

        $this->tag('a');
        $this->url($url, $openInNewTab);

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
        
        $label = $this->evaluate($this->label)
            ?? (string) str($this->getName())
                ->beforeLast('.')
                ->afterLast('.')
                ->replace(['-', '_'], ' ')
                ->title();

        return $label;
    }

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }

    protected static function getDefaultName(): string
    {
        $parts = explode('\\', static::class);

        return Str::kebab(end($parts));
    }
}
