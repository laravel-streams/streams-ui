<?php

namespace Streams\Ui\Livewire\Widgets\Stats;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Streams\Ui\Builders\Concerns as Common;

class Stat extends Component implements Htmlable
{
    use Common\CanSpanColumns;
    use Common\EvaluatesClosures;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasUrl;
    use Common\HasValue;

    final public function __construct(string|Htmlable $label, $value)
    {
        $this->label($label);
        $this->value($value);
    }

    public static function make(string|Htmlable $label, $value): static
    {
        $instance = app(static::class, [
            'label' => $label,
            'value' => $value,
        ]);

        // @todo This is a livewire component not a builder
        // $instance->configure();

        return $instance;
    }

    public function toHtml(): string
    {
        return $this->render()->render();
    }

    public function render(): View
    {
        return view('ui::builders.stat', $this->data());
    }
}
