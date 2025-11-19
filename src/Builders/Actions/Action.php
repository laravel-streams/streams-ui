<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Actions;
use Streams\Ui\Builders\Concerns as Common;

// StaticAction
class Action extends ViewBuilder
{
    use Common\CanBeDisabled;
    use Common\CanBeHidden;
    use Common\HasBadge;
    use Common\HasColor;
    use Common\HasEntry;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasName;
    use Common\HasSize;
    use Common\HasUrl;
    use Concerns\CanOpenModal;
    use Concerns\HasAction;
    use Concerns\HasArguments;
    use Concerns\HasBorderRadius;
    use Concerns\HasForm;
    use Concerns\HasKeyBindings;
    use Concerns\HasStyle;
    use Concerns\HasTag;
    use Concerns\HasTooltip;
    
    // use Concerns\CanBeLabeledFrom;
    // use Concerns\CanBeOutlined;
    // use Concerns\CanCallParentAction;
    // use Concerns\CanClose;
    // use Concerns\CanDispatchEvent;
    // use Concerns\CanSubmitForm;
    // use Concerns\HasGroupedIcon;
    // use Concerns\HasSize;
    // use Concerns\HasTooltip;

    protected string $view = 'ui::action';

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
