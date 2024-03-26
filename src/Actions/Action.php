<?php

namespace Streams\Ui\Actions;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\ViewBuilder;

class Action extends ViewBuilder
{
    use Traits\HasTag;
    use Traits\HasAction;
    use Traits\HasArguments;
    use Traits\InteractsWithEntry;

    use Common\HasUrl;
    use Common\HasIcon;
    use Common\HasName;
    use Common\HasBadge;
    use Common\HasColor;
    use Common\HasLabel;
    use Common\CanBeHidden;
    use Common\CanBeDisabled;
    use Common\HasHtmlAttributes;

    // use Common\HasSize;
    // use Common\HasTooltip;
    // use Common\HasKeyBindings;
    
    // use Concerns\CanBeLabeledFrom;
    // use Concerns\CanBeOutlined;
    // use Concerns\CanCallParentAction;
    // use Concerns\CanClose;
    // use Concerns\CanDispatchEvent;
    // use Concerns\CanSubmitForm;
    // use Concerns\HasGroupedIcon;

    protected string $view = 'ui::action';

    protected string $viewIdentifier = 'action';

    protected string $evaluationIdentifier = 'action';

    public function __construct(string $name)
    {
        $this->name($name);
    }

    static public function make($name): static
    {
        $static = new static($name);

        $static->configure();

        return $static;
    }

    public function getLabel(): string
    {
        $label = $this->evaluate($this->label)
            ?? (string) str($this->getName())
                ->beforeLast('.')
                ->afterLast('.')
                ->kebab()
                ->replace(['-', '_'], ' ')
                ->title();

        return $label;
    }
}
