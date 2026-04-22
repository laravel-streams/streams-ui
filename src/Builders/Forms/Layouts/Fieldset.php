<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Livewire\Component;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class Fieldset extends ViewBuilder
{
    use Common\BelongsToLivewire;
    use Common\BelongsToParent;
    use Common\HasComponents;
    use Common\HasHtmlAttributes;
    use Common\HasId;
    use Common\HasLabel;

    protected string $view = 'ui::components.form.fieldset';

    public function __construct(
        string|array|\Closure|null $label = null
    ) {
        is_array($label)
            ? $this->components($label)
            : $this->label($label);
    }

    public static function make(
        string|array|\Closure|null $label = null
    ): static {
        $instance = app(static::class, ['label' => $label]);

        $instance->configure();

        return $instance;
    }

    public static function for(
        Component $livewire,
        string|array|\Closure|null $label = null
    ): static {
        $static = app(static::class, ['label' => $label]);

        $static->livewire($livewire);
        $static->configure();

        return $static;
    }
}
