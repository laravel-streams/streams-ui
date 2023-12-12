<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Streams\Ui\Builders\ViewComponent;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasLabel;
use Streams\Ui\Builders\Forms\Concerns\HasComponents;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;

class Fieldset extends ViewComponent
{
    use HasId;
    use HasLabel;
    use HasComponents;
    use HasHtmlAttributes;

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
