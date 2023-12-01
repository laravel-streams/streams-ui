<?php

namespace Streams\Ui\Forms\Layouts;

use Streams\Ui\Support\ViewComponent;
use Streams\Ui\Support\Concerns\HasId;
use Streams\Ui\Support\Concerns\HasLabel;
use Streams\Ui\Forms\Concerns\HasComponents;
use Streams\Ui\Support\Concerns\HasHtmlAttributes;

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
