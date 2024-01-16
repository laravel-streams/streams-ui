<?php

namespace Streams\Ui\Forms\Layouts;

use Illuminate\Support\Str;
use Streams\Ui\Builders\ViewComponent;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasIcon;
use Streams\Ui\Builders\Concerns\HasBadge;
use Streams\Ui\Builders\Concerns\HasLabel;
use Streams\Ui\Forms\Concerns\HasComponents;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;

class Tab extends ViewComponent
{
    use HasId;
    use HasIcon;
    use HasBadge;
    use HasLabel;
    use HasComponents;
    use HasHtmlAttributes;

    protected string $view = 'ui::components.tabs.tab';

    final public function __construct(string $label)
    {
        $this->label($label);

        $this->id(Str::slug($label));
    }

    public static function make(string $label): static
    {
        $static = app(static::class, ['label' => $label]);
        
        $static->configure();

        return $static;
    }
}
