<?php

namespace Streams\Ui\Widgets\Stats;

use Illuminate\View\Component;
use Streams\Ui\Traits as Common;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;

class Stat extends Component implements Htmlable
{
    use Common\HasId;
    use Common\HasUrl;
    use Common\HasLabel;
    use Common\HasValue;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    
    use Common\EvaluatesClosures;

    final public function __construct(string | Htmlable $label, $value)
    {
        $this->label($label);
        $this->value($value);
    }

    public static function make(string | Htmlable $label, $value): static
    {
        return app(static::class, ['label' => $label, 'value' => $value]);
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
