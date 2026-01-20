<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Actions;
use Streams\Ui\Builders\Concerns as Common;

class Action extends ViewBuilder
{
    use Common\CanBeHidden;
    use Common\CanBeDisabled;

    use Common\HasId;
    use Common\HasUrl;
    use Common\HasIcon;
    use Common\HasName;
    use Common\HasSize;
    use Common\HasBadge;
    use Common\HasColor;
    use Common\HasEntry;
    use Common\HasLabel;
    use Common\HasTooltip;
    use Common\HasHtmlAttributes;
    
    use Concerns\HasTag;
    use Concerns\HasForm;
    use Concerns\HasStyle;
    use Concerns\HasArguments;
    use Concerns\HasKeyBindings;
    use Concerns\HasBorderRadius;

    // use Concerns\CanBeLabeledFrom;
    // use Concerns\CanBeOutlined;

    protected string $view = 'ui::builders.action';

    protected string $viewIdentifier = 'action';

    protected string $evaluationIdentifier = 'action';

    public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make($name): static
    {
        $static = new static($name);

        $static->configure();

        Actions::register($name, $static);

        return $static;
    }

    public static function register($name): static
    {
        Actions::register($name, $action = static::make($name));

        return $action;
    }

    public function link(
        string|\Closure|null $url = null,
        bool|\Closure $openInNewTab = false
    ) {
        $this->style(__FUNCTION__);

        $this->tag('a');
        $this->url($url, $openInNewTab);

        return $this;
    }

    public function getLabel(): string
    {
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
}
