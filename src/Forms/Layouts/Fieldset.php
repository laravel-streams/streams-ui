<?php

namespace Streams\Ui\Forms\Layouts;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\Concerns;
use Streams\Ui\Builders\ViewBuilder;

class Fieldset extends ViewBuilder
{
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasComponents;
    use Common\HasHtmlAttributes;

    use Common\BelongsToParent;
    use Common\BelongsToLivewire;

    protected string $view = 'ui::components.form.fieldset';

    public function __construct(
        string | array | \Closure | null $label = null
    ) {
        is_array($label)
            ? $this->components($label)
            : $this->label($label);
    }

    public static function make(
        string | array | \Closure | null $label = null
    ): static {
        $static = app(static::class, ['label' => $label]);

        $static->configure();

        return $static;
    }
}
